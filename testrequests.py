import requests

url = 'http://192.168.137.2/request'

# set the bit value to 1
bit = 1

# send the HTTP POST request with the bit value as a parameter
response = requests.post(url, data={'bit': bit})

# print the response from the server
print(response.content)