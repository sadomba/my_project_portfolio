from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from bs4 import BeautifulSoup
import pandas as pd

# Configure Selenium WebDriver (choose your browser driver)
driver = webdriver.Firefox()  # Adjust path as needed

# Target URL
url = 'https://betting.co.zw/sportsbook/upcoming'

# Open the URL
driver.get(url)

# Wait for the <app-root> element to be present
WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.TAG_NAME, 'app-root')))

# Get the page source
html = driver.page_source

# Close the browser
driver.quit()

# Parse HTML
soup = BeautifulSoup(html, 'html.parser')

# Locate the table within the <app-root> element
tables = soup.find_all('table')

if not tables:
    print("No tables found within the specified structure.")
    exit()

# Extract data from the table
data = []
for table in tables:
    rows = table.find_all('tr')
    for row in rows:
        cells = row.find_all('td')
        if cells and len(cells) >= 2:  # Ensure there are enough columns
            teams = cells[0].get_text(strip=True)
            odds = cells[1].get_text(strip=True)
            data.append([teams, odds])

# Create a DataFrame from the extracted data
df = pd.DataFrame(data, columns=['Teams', 'Odds'])

# Filter the DataFrame to only include rows where the length of the 'Odds' string is above 10
filtered_df = df[df['Odds'].str.len() > 10]

# Display the filtered DataFrame
print(filtered_df)

# Optionally save to a CSV file
filtered_df.to_csv('odds_filtered.csv', index=False)
