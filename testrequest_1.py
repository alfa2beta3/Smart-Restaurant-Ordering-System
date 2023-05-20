import requests

url = "http://192.168.137.2/25/off"

try:
    response = requests.get(url)
    if response.status_code == 200:
        print("HTTP request successful.")
    else:
        print(f"HTTP request failed with status code: {response.status_code}")
except requests.exceptions.RequestException as e:
    print("An error occurred during the HTTP request:", e)