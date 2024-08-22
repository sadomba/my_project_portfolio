import sys
from PyQt5.QtWidgets import QApplication, QMainWindow, QPushButton, QVBoxLayout, QWidget, QTableWidget, QTableWidgetItem, QHeaderView, QComboBox, QHBoxLayout
from PyQt5.QtCore import Qt
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from bs4 import BeautifulSoup
import pandas as pd

class ArbitrageCalculator(QMainWindow):
    def __init__(self):
        super().__init__()
        self.initUI()

    def initUI(self):
        self.setWindowTitle('Arbitrage Betting Calculator')
        self.setGeometry(100, 100, 1200, 800)

        # Main layout
        layout = QVBoxLayout()

        # Horizontal layout for dropdown and button
        top_layout = QHBoxLayout()

        # Dropdown for sport selection
        self.sport_dropdown = QComboBox()
        self.sport_dropdown.addItems([
            "Soccer", "Basketball", "Tennis", "MMA", "Baseball", "Boxing", 
            "Rugby", "Cricket", "Handball", "Ice Hockey", "Snooker", 
            "Table tennis", "Waterpolo", "Volleyball", "Beach Volley"
        ])
        top_layout.addWidget(self.sport_dropdown)

        # Button
        self.calculate_button = QPushButton('Calculate Arbitrage')
        self.calculate_button.clicked.connect(self.calculate_arbitrage)
        top_layout.addWidget(self.calculate_button)

        layout.addLayout(top_layout)

        # Table for results
        self.table = QTableWidget()
        layout.addWidget(self.table)

        # Set the main layout
        central_widget = QWidget()
        central_widget.setLayout(layout)
        self.setCentralWidget(central_widget)

    def calculate_arbitrage(self):
        selected_sport = self.sport_dropdown.currentText()
        
        # Configure Selenium WebDriver
        driver = webdriver.Firefox()  # Adjust path as needed

        # Target URL
        url = 'https://betting.co.zw/sportsbook/upcoming'

        # Open the URL
        driver.get(url)

        # Wait for the <app-root> element to be present
        WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.TAG_NAME, 'app-root')))

        # Find and click the selected sport
        sport_elements = driver.find_elements(By.XPATH, f"//li[contains(., '{selected_sport}')]")
        if sport_elements:
            sport_elements[0].click()
            # Wait for the page to load after clicking
            WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.TAG_NAME, 'table')))

        # Get the page source
        html = driver.page_source

        # Close the browser
        driver.quit()

        # Parse HTML
        soup = BeautifulSoup(html, 'html.parser')

        # Locate the table within the <app-root> element
        tables = soup.find_all('table')

        if not tables:
            print(f"No tables found for {selected_sport}.")
            return

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
        filtered_df = df[df['Odds'].str.len() > 10].copy()

        # Function to split the 'Odds' string into three parts
        def split_odds(odds):
            parts = odds.split('.')
            if len(parts) >= 4:
                var1 = float(parts[0] + '.' + parts[1][:2])  # First part
                var2 = float(parts[1][2:] + '.' + parts[2][:2])  # Second part
                var3 = float(parts[2][2:] + '.' + parts[3][:2])  # Third part
                return pd.Series([var1, var2, var3])
            else:
                return pd.Series([None, None, None])

        # Apply the function to create new columns
        filtered_df[['Odd1', 'Odd2', 'Odd3']] = filtered_df['Odds'].apply(split_odds)

        # Drop the original 'Odds' column as it's no longer needed
        filtered_df.drop(columns=['Odds'], inplace=True)

        # Arbitrage betting function
        def arbitrage_betting(odd1, odd2, odd3, total_stake):
            # Calculate the arbitrage percentage
            arb_percentage = (1 / odd1) + (1 / odd2) + (1 / odd3)
            
            # Calculate the stakes for each bet
            stake1 = (total_stake / (odd1 * arb_percentage))
            stake2 = (total_stake / (odd2 * arb_percentage))
            stake3 = (total_stake / (odd3 * arb_percentage))
            
            # Calculate the total payout for each outcome
            total_payout1 = stake1 * odd1
            total_payout2 = stake2 * odd2
            total_payout3 = stake3 * odd3
            
            # Calculate the profit
            total_payout = total_payout1  # Since all payouts should be the same in arbitrage
            profit = total_payout - total_stake
            
            return {
                'Stake 1': stake1,
                'Stake 2': stake2,
                'Stake 3': stake3,
                'Total Payout': total_payout,
                'Profit': profit
            }

        # Given total stake
        total_stake = 100

        # Apply arbitrage betting calculation for each row and add results to DataFrame
        arbitrage_results = filtered_df.apply(
            lambda row: pd.Series(arbitrage_betting(row['Odd1'], row['Odd2'], row['Odd3'], total_stake)),
            axis=1
        )

        # Merge the arbitrage results with the filtered DataFrame
        final_df = pd.concat([filtered_df, arbitrage_results], axis=1)

        # Display results in the table
        self.display_results(final_df)

        # Optionally save to a CSV file
        final_df.to_csv(f'{selected_sport}_odds_arbitrage_results.csv', index=False)

    def display_results(self, df):
        # Clear the table
        self.table.clear()

        # Set table dimensions
        self.table.setRowCount(df.shape[0])
        self.table.setColumnCount(df.shape[1])

        # Set headers
        self.table.setHorizontalHeaderLabels(df.columns)

        # Populate the table
        for row in range(df.shape[0]):
            for col in range(df.shape[1]):
                item = QTableWidgetItem(str(df.iloc[row, col]))
                item.setTextAlignment(Qt.AlignCenter)
                self.table.setItem(row, col, item)

        # Resize columns to content
        self.table.resizeColumnsToContents()

        # Set table to fill the available space
        header = self.table.horizontalHeader()
        header.setSectionResizeMode(QHeaderView.Stretch)

if __name__ == '__main__':
    app = QApplication(sys.argv)
    ex = ArbitrageCalculator()
    ex.show()
    sys.exit(app.exec_())
