import sys
import time
from PyQt5.QtWidgets import QApplication, QMainWindow, QPushButton, QVBoxLayout, QWidget, QTableWidget, QTableWidgetItem, QHeaderView, QComboBox, QHBoxLayout, QMessageBox
from PyQt5.QtCore import Qt
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException, NoSuchElementException, WebDriverException
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

    def show_error_message(self, message):
        msg_box = QMessageBox()
        msg_box.setIcon(QMessageBox.Critical)
        msg_box.setText(message)
        msg_box.setWindowTitle("Error")
        msg_box.exec_()

    def calculate_arbitrage(self):
        selected_sport = self.sport_dropdown.currentText()
        
        try:
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
                time.sleep(5)  # Add a delay to ensure the page loads properly
                WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.TAG_NAME, 'table')))

            # Get the page source
            html = driver.page_source

        except TimeoutException:
            self.show_error_message("Timeout occurred. The webpage took too long to load.")
            driver.quit()
            return
        except NoSuchElementException:
            self.show_error_message("An expected element was not found on the webpage.")
            driver.quit()
            return
        except WebDriverException as e:
            self.show_error_message(f"Webdriver error: {e}")
            driver.quit()
            return
        except Exception as e:
            self.show_error_message(f"An unexpected error occurred: {e}")
            driver.quit()
            return

        # Close the browser
        driver.quit()

        try:
            # Print the HTML for debugging purposes
            print(html)

            # Parse HTML
            soup = BeautifulSoup(html, 'html.parser')

            # Locate the table within the <app-root> element
            tables = soup.find_all('table')

            if not tables:
                self.show_error_message(f"No tables found for {selected_sport}.")
                return

            # Extract data from the table
            data = []
            headers = []
            for table in tables:
                # Extract headers
                header_row = table.find('tr')
                if header_row:
                    headers = [th.get_text(strip=True) for th in header_row.find_all('th')]

                # Extract rows
                rows = table.find_all('tr')
                for row in rows[1:]:  # Skip header row if headers exist
                    cells = row.find_all('td')
                    if len(cells) != len(headers):
                        continue  # Skip rows with mismatched columns
                    row_data = [cell.get_text(strip=True) if cell.get_text(strip=True) else None for cell in cells]
                    data.append(row_data)

            # Check if headers were found
            if not headers or not data:
                self.show_error_message(f"No valid data found for {selected_sport}.")
                return

            # Create a DataFrame from the extracted data
            df = pd.DataFrame(data, columns=headers)

            # Filter out rows where any column is None
            df.dropna(how='any', inplace=True)

            # Function to split the 'Odds' string into parts
            def split_odds(odds):
                parts = odds.split('.')
                if len(parts) >= 4:
                    var1 = float(parts[0] + '.' + parts[1][:2])  # First part
                    var2 = float(parts[1][2:] + '.' + parts[2][:2])  # Second part
                    var3 = float(parts[2][2:] + '.' + parts[3][:2])  # Third part
                    
                    odd1 = var1
                    odd2 = var2
                    odd3 = var3
                    total_stake = 100
                    arb_percentage = (1 / odd1) + (1 / odd2) + (1 / odd3)
        
                    # Calculate the stakes for each bet
                    stake1 = (total_stake / (odd1 * arb_percentage))
                    stake2 = (total_stake / (odd2 * arb_percentage))
                    stake3 = (total_stake / (odd3 * arb_percentage))
                    
                    # Calculate the total payout for each outcome
                    total_payout = stake1 * odd1
                 
                    
                    # Calculate the profit
                     # Since all payouts should be the same in arbitrage
                    profit = total_payout - total_stake
                    
                    return pd.Series([stake1, stake2, stake3, total_payout, profit])
                    
                elif len(parts) == 3:
                    var1 = float(parts[0] + '.' + parts[1][:2])  # First part
                    var2 = float(parts[1][2:] + '.' + parts[2][:2])  # Second part
                    
                    odd1 = var1
                    odd2 = var2
                    total_stake = 100
                    arb_percentage = (1 / odd1) + (1 / odd2)
        
                    # Calculate the stakes for each bet
                    stake1 = (total_stake / (odd1 * arb_percentage))
                    stake2 = (total_stake / (odd2 * arb_percentage))
                    
                    # Calculate the total payout for each outcome
                    total_payout = stake1 * odd1
                    
                    
                    # Calculate the profit
                     # Since all payouts should be the same in arbitrage
                    profit = total_payout - total_stake
                    
                    return pd.Series([stake1, stake2, total_payout, profit])
                    return pd.Series([var1, var2, None])
                else:
                    return pd.Series([None, None, None])

            # Identify columns with odds and split them, skipping the first column
            for col in df.columns[1:]:  # Skip the first column
                if df[col].dtype == object:  # Check if the column is of string type
                    try:
                        split_data = df[col].apply(split_odds)
                        split_data.columns = [f"{col}_part1", f"{col}_part2", f"{col}_part3"]
                        df = df.drop(columns=[col]).join(split_data)
                    except Exception as e:
                        self.show_error_message(f"Error processing column {col}: {e}")
                        continue

            # Convert all column names to strings
            df.columns = df.columns.astype(str)

            # Display the results in the table
            self.display_results(df)

        except Exception as e:
            self.show_error_message(f"Error parsing HTML or processing data: {e}")

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

        # Calculate and display arbitrage opportunities
        for index, row in df.iterrows():
            if not pd.isna(row['Column_part3']):
                arb_result = self.arbitrage_betting(row['Column_part1'], row['Column_part2'], row['Column_part3'], total_stake=100)
            else:
                arb_result = self.arbitrage_betting_two(row['Column_part1'], row['Column_part2'], total_stake=100)
            print(f"Arbitrage Result for Row {index}: {arb_result}")

    def arbitrage_betting(self, odd1, odd2, odd3, total_stake):
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

    def arbitrage_betting_two(self, odd1, odd2, total_stake):
        # Calculate the arbitrage percentage
        arb_percentage = (1 / odd1) + (1 / odd2)
        
        # Calculate the stakes for each bet
        stake1 = (total_stake / (odd1 * arb_percentage))
        stake2 = (total_stake / (odd2 * arb_percentage))
        
        # Calculate the total payout for each outcome
        total_payout1 = stake1 * odd1
        total_payout2 = stake2 * odd2
        
        # Calculate the profit
        total_payout = total_payout1  # Since all payouts should be the same in arbitrage
        profit = total_payout - total_stake
        
        return {
            'Stake 1': stake1,
            'Stake 2': stake2,
            'Total Payout': total_payout,
            'Profit': profit
        }

if __name__ == '__main__':
    app = QApplication(sys.argv)
    ex = ArbitrageCalculator()
    ex.show()
    sys.exit(app.exec_())
