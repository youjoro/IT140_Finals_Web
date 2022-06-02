import matplotlib.pyplot as plt
import matplotlib.dates as md
import sys
import json
from datetime import datetime

plt.style.use('bmh')

json_data = sys.argv[1]

parsed_json = json.loads(json_data)

temperature_y = []
humidity_y = []
moisture_y = []
time_x = []

for data in parsed_json:
    temperature_y.append(data['Temperature'])
    humidity_y.append(data['Humidity'])
    moisture_y.append(data['Moisture'])

    date = datetime.fromtimestamp(int(data['reading_time']))
    time_x.append(date)

fig, ax = plt.subplots(figsize=(10, 5))
  
plt.plot(time_x, temperature_y, label = "Temperature", marker='o')
plt.plot(time_x, humidity_y, label = "Humidity", marker='o')
plt.plot(time_x, moisture_y, label = "Moisture", marker='o')
plt.legend()

ax.xaxis.set_major_locator(md.HourLocator(interval=1))
ax.xaxis.set_major_formatter(md.DateFormatter('%H:%M'))

ax.set_title("Plant Readings", fontsize=20)
plt.xticks(fontsize=12)
plt.yticks(fontsize=12)

plt.savefig('graph_output/graph.png', transparent=True)