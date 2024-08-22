from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException, NoSuchElementException, WebDriverException
import time

def fetch_data(selected_sport):
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

        # Close the browser
        driver.quit()
        
        return html

    except TimeoutException:
        driver.quit()
        raise TimeoutException("Timeout occurred. The webpage took too long to load.")
    except NoSuchElementException:
        driver.quit()
        raise NoSuchElementException("An expected element was not found on the webpage.")
    except WebDriverException as e:
        driver.quit()
        raise WebDriverException(f"Webdriver error: {e}")
    except Exception as e:
        driver.quit()
        raise Exception(f"An unexpected error occurred: {e}")
