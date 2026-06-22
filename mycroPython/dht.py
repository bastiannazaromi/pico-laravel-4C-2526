import time
import network
import urequests
import machine
import utime
from machine import Pin
import dht

dht_pin = Pin(15, Pin.IN)
dht_sensor = dht.DHT22(dht_pin)

time.sleep(3)

SSID = "LAB HARDWARE 2"
PASSWORD = "harkatnegeri"

wlan = network.WLAN(network.STA_IF)
wlan.active(True)

if not wlan.isconnected():
    wlan.connect(SSID, PASSWORD)

    while not wlan.isconnected():
        print("Menghubungkan ke WiFi...")
        time.sleep(2)

print("Terhubung dengan IP:", wlan.ifconfig()[0])
time.sleep(3)

base_url = "http://192.168.21.57:8000/api"
post_dht_url = base_url + "/sensor"

last_dht_time = time.time()

led = machine.Pin("LED", machine.Pin.OUT)

while True:
    led.value(1)
    utime.sleep(1)

    led.value(0)
    utime.sleep(0.4)

    now = time.time()

    if now - last_dht_time >= 10:
        try:
            dht_sensor.measure()

            temperature = dht_sensor.temperature()
            humidity = dht_sensor.humidity()

            data_json = {
                "temperature": temperature,
                "humidity": humidity
            }

            response = urequests.post(
                post_dht_url,
                json=data_json
            )

            print("[POST] DHT SEND:", response.text.strip())
            response.close()

        except Exception as e:
            print("Gagal ambil atau kirim DHT:", e)

        last_dht_time = now