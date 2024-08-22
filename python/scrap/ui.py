import sys
from PyQt5.QtWidgets import QMainWindow, QPushButton, QVBoxLayout, QWidget, QTableWidget, QTableWidgetItem, QHeaderView, QComboBox, QHBoxLayout, QMessageBox, QLineEdit, QLabel
from PyQt5.QtCore import Qt
from selenium_operations import fetch_data
from utils import split_odds
import pandas as pd

class LoginPage(QMainWindow):
    def __init__(self):
        super().__init__()
        self.initUI()

    def initUI(self):
        self.setWindowTitle('Login')
        self.setGeometry(100, 100, 400, 200)

        # Main layout
        layout = QVBoxLayout()

        # Username field
        self.username_label = QLabel('Username:')
        self.username_input = QLineEdit()
        layout.addWidget(self.username_label)
        layout.addWidget(self.username_input)

        # Password field
        self.password_label = QLabel('Password:')
        self.password_input = QLineEdit()
        self.password_input.setEchoMode(QLineEdit.Password)
        layout.addWidget(self.password_label)
        layout.addWidget(self.password_input)

        # Login button
        self.login_button = QPushButton('Login')
        self.login_button.clicked.connect(self.login)
        layout.addWidget(self.login_button)

        # Set the layout
        central_widget = QWidget()
        central_widget.setLayout(layout)
        self.setCentralWidget(central_widget)

    def login(self):
        # Simple login logic
        username = self.username_input.text()
        password = self.password_input.text()
        if username == 'admin' and password == 'password':
            self.hide()
            self.main_window = ArbitrageCalculator()
            self.main_window.show()
        else:
            QMessageBox.warning(self, 'Error', 'Invalid username or password')

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

        # Apply stylesheet
        with open('styles.qss', 'r') as f:
            self.setStyleSheet(f.read())

    def show_error_message(self, message):
        msg_box = QMessageBox()
        msg_box.setIcon(QMessageBox.Critical)
        msg_box.setText(message)
        msg_box.setWindowTitle("Error")
        msg_box.exec_()

    def calculate_arbitrage(self):
        selected_sport = self.sport_dropdown.currentText()
        try:
            html = fetch_data(selected_sport)
            self.process_html(html, selected_sport)
        except Exception as e:
            self.show_error_message(f"An unexpected error occurred: {e}")

    def process_html(self, html, selected_sport):
        try:
            # Parse HTML and extract data
            data, headers = parse_html(html, selected_sport)
            if not headers or not data:
                self.show_error_message(f"No valid data found for {selected_sport}.")
                return

            # Create a DataFrame from the extracted data
            df = pd.DataFrame(data, columns=headers)

            # Filter out rows where any column is None
            df.dropna(how='any', inplace=True)

            # Split odds
            df = split_odds(df)

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
