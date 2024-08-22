import tkinter as tk
from tkinter import scrolledtext
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException, NoSuchElementException
from bs4 import BeautifulSoup
import pandas as pd

def arbitrage_betting(odd1, odd2, odd3, total_stake):
    arb_percentage = (1 / odd1) + (1 / odd2) + (1 / odd3)
    stake1 = (total_stake / (odd1 * arb_percentage))
    stake2 = (total_stake / (odd2 * arb_percentage))
    stake3 = (total_stake / (odd3 * arb_percentage))
    total_payout1 = stake1 * odd1
    profit = total_payout1 - total_stake
    return {'Stake 1': stake1, 'Stake 2': stake2, 'Stake 3': stake3, 'Total Payout': total_payout1, 'Profit': profit}

def split_odds(odds):
    parts = odds.split('.')
    if len(parts) >= 4:
        var1 = float(parts[0] + '.' + parts[1][:2])
        var2 = float(parts[1][2:] + '.' + parts[2][:2])
        var3 = float(parts[2][2:] + '.' + parts[3][:2])
        return pd.Series([var1, var2, var3])
    else:
        return pd.Series([None, None, None])

def run_arbitrage_calculations(sport):
    total_stake = 100

    driver = webdriver.Firefox()
    url = 'https://betting.co.zw/sportsbook/upcoming'
    driver.get(url)

    try:
        WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.TAG_NAME, 'app-root')))
        sport_checkbox = WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.XPATH, f"//label[contains(text(), '{sport}')]/input"))
        )
        driver.execute_script("arguments[0].click();", sport_checkbox)
        WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.CSS_SELECTOR, "table")))
    except TimeoutException:
        output_text.delete(1.0, tk.END)
        output_text.insert(tk.END, f"Timeout: Unable to find the {sport} checkbox or table.")
        driver.quit()
        return
    except NoSuchElementException:
        output_text.delete(1.0, tk.END)
        output_text.insert(tk.END, f"Element not found: Unable to find the {sport} checkbox.")
        driver.quit()
        return

    html = driver.page_source
    driver.quit()

    soup = BeautifulSoup(html, 'html.parser')
    tables = soup.find_all('table')

    if not tables:
        output_text.delete(1.0, tk.END)
        output_text.insert(tk.END, "No tables found within the specified structure.")
        return

    data = []
    for table in tables:
        rows = table.find_all('tr')
        for row in rows:
            cells = row.find_all('td')
            if cells and len(cells) >= 2:
                teams = cells[0].get_text(strip=True)
                odds = cells[1].get_text(strip=True)
                data.append([teams, odds])

    df = pd.DataFrame(data, columns=['Teams', 'Odds'])
    filtered_df = df[df['Odds'].str.len() > 10].copy()
    filtered_df[['Odd1', 'Odd2', 'Odd3']] = filtered_df['Odds'].apply(split_odds)
    filtered_df.drop(columns=['Odds'], inplace=True)

    arbitrage_results = filtered_df.apply(
        lambda row: pd.Series(arbitrage_betting(row['Odd1'], row['Odd2'], row['Odd3'], total_stake)),
        axis=1
    )

    final_df = pd.concat([filtered_df, arbitrage_results], axis=1)
    output_text.delete(1.0, tk.END)
    output_text.insert(tk.END, final_df.to_string())

root = tk.Tk()
root.title("Arbitrage Betting Calculator")

sports = ['Football', 'Basketball', 'Tennis']
for sport in sports:
    button = tk.Button(root, text=f"Run {sport} Arbitrage Calculations", command=lambda s=sport: run_arbitrage_calculations(s))
    button.pack(pady=5)

output_text = scrolledtext.ScrolledText(root, width=100, height=30)
output_text.pack(pady=10)

root.mainloop()
