from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException, NoSuchElementException, WebDriverException
from bs4 import BeautifulSoup

class Scraper:
    def scrape(self, sport):
        try:
            driver = webdriver.Firefox()  # Adjust path as needed
            url = 'https://betting.co.zw/sportsbook/upcoming'
            driver.get(url)
            WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.TAG_NAME, 'app-root')))
            sport_elements = driver.find_elements(By.XPATH, f"//li[contains(., '{sport}')]")
            if sport_elements:
                sport_elements[0].click()
                WebDriverWait(driver, 10).until(EC.presence_of_element_located((By.TAG_NAME, 'table')))
                html = driver.page_source
                driver.quit()
                return html
        except (TimeoutException, NoSuchElementException, WebDriverException) as e:
            print(f"Error: {e}")
            driver.quit()
        return None
