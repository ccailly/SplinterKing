from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.desired_capabilities import DesiredCapabilities

from fake_useragent import UserAgent

from kingToken import Token
from kingdom import Kingdom
from kingProfile import Profile

import time
import json
import requests


def get_driver():
    options = webdriver.ChromeOptions()
    options.add_argument('--ignore-ssl-errors=yes')
    options.add_argument('--ignore-certificate-errors')

    # Fake user agent
    ua = UserAgent()
    user_agent = ua.random
    options.add_argument(f'user-agent={user_agent}')

    caps = DesiredCapabilities.CHROME
    caps['goog:loggingPrefs'] = {'performance': 'ALL'}
    driver = webdriver.Remote(
        command_executor='http://cloud.fragmentdev.tk:4444/wd/hub',
        options=options,
        desired_capabilities=caps
    )
    driver.maximize_window()
    return driver


def login(driver, mail, password):
    driver.get("https://www.burgerking.fr/connexion")
    # Check if the cookie banner is present
    try:
        cookie = driver.find_element(
            By.XPATH, "//button[contains(text(), 'Tout refuser') and @color='#BB1E32']")
        if cookie:
            cookie.click()
    except Exception as e:
        print(e)

    form = driver.find_element(By.XPATH, "//form[@action='#']")
    mail_input = driver.find_element(
        By.XPATH, "//input[@name='email' and @type='email' and @placeholder='Tapez ici votre adresse e-mail']")
    mail_input.send_keys(mail)
    password_input = driver.find_element(
        By.XPATH, "//input[@name='password' and @type='password' and @placeholder='Tapez ici votre mot de passe']")
    password_input.send_keys(password)

    cpt = 0
    while cpt < 10:
        try:
            btn = driver.find_element(
                By.XPATH, "//button[@type='submit' and contains(text(), 'Me connecter')]")
            btn.click()
            time.sleep(1)
        except Exception as e:
            break

        cpt += 1

    if cpt >= 10:
        raise Exception("Could not login, probably temporary ban.")


def process_browser_logs_for_network_events(logs):
    """
    Return only logs which have a method that start with "Network.response", "Network.request", or "Network.webSocket"
    since we're interested in the network events specifically.
    """
    for entry in logs:
        log = json.loads(entry["message"])["message"]
        if (
                "Network.response" in log["method"]
                or "Network.request" in log["method"]
                or "Network.webSocket" in log["method"]
        ):
            yield log


def get_bearer_token(driver):
    logs = driver.get_log("performance")
    events = process_browser_logs_for_network_events(logs)
    for event in events:
        if 'params' in event and 'request' in event['params'] and 'url' in event['params']['request'] and 'method' in event['params']['request']:
            if 'webapi.burgerking.fr' in event['params']['request']['url'] and event['params']['request']['method'] == 'GET':
                if event['params']['request']['url'] == 'https://webapi.burgerking.fr/blossom/api/v12/kingdom/points':
                    return Token(event['params']['request']['headers']['Authorization'].split(' ')[1])


def get_kingdom(token, mail, password):
    headers = {'Accept': 'application/json, text/plain, */*', 'Authorization': 'Bearer ' + token.token, 'Referer': 'https://www.burgerking.fr/', 'RenewToken': 'true',
               'User-Agent': 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.41 Safari/537.36', 'x-application': 'WEBSITE', 'x-platform': 'WEB'}

    request = requests.get(
        'https://webapi.burgerking.fr/blossom/api/v12/kingdom', headers=headers)
    token.token = request.headers['Authorization'].split(' ')[1]

    return Kingdom(mail, password, request.json())


def get_profile(token, mail):
    headers = {'Accept': 'application/json, text/plain, */*', 'Authorization': 'Bearer ' + token.token, 'Referer': 'https://www.burgerking.fr/', 'RenewToken': 'true',
               'User-Agent': 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.41 Safari/537.36', 'x-application': 'WEBSITE', 'x-platform': 'WEB'}

    request = requests.get(
        'https://webapi.burgerking.fr/blossom/api/v12/kingdom/profile', headers=headers)
    token.token = request.headers['Authorization'].split(' ')[1]

    return Profile(mail, request.json())


# driver = get_driver()
# mail = "zQo2FHQXdh7xjIH@mailsac.com"
# password = "BKGen2042271!"
# login(driver, mail, password)
# while (token := get_bearer_token(driver)) is None:
#     time.sleep(1)
# kingdom = get_kingdom(token, mail, password)
# profile = get_profile(token, mail)

# print(kingdom)
# print(profile)

# order_nuggets(driver)
# time.sleep(10)

# driver.close()
# driver.quit()
