import matplotlib.pyplot as plt
import matplotlib.dates as md
from matplotlib.ticker import AutoMinorLocator
import sys
import json
from datetime import datetime
import numpy as np

plt.style.use('bmh')

json_data = sys.argv[1]

parsed_json = json.loads(json_data)

if not parsed_json:
    exit(1)

temperature_y = []
humidity_y = []
moisture_y = []
time_x = []

title = ""

for data in parsed_json:
    temperature_y.append(float(data['Temperature']))
    humidity_y.append(float(data['Humidity']))
    moisture_y.append(float(data['Moisture']))

    date = datetime.fromtimestamp(int(data['reading_time']))
    time_x.append(date)

    title = data['device_id']

fig, ax = plt.subplots(figsize=(10, 5))
  
plt.plot(time_x, temperature_y, label = "Temperature", marker='o')
plt.plot(time_x, humidity_y, label = "Humidity", marker='o')
plt.plot(time_x, moisture_y, label = "Moisture", marker='o')
plt.legend(loc='upper center', bbox_to_anchor=(0.5, -0.25),
          fancybox=True, shadow=True, ncol=3, fontsize=20)

ax.xaxis.set_major_locator(md.MinuteLocator(byminute=[0,15,30,45], interval=1))
ax.xaxis.set_major_formatter(md.DateFormatter('%H:%M'))

ax.yaxis.set_minor_locator(AutoMinorLocator(5.0))

ax.set_title(f"Plant Readings For Device ID {title}", fontsize=20)
plt.xticks(fontsize=15, rotation=45, ha='right')
plt.yticks(fontsize=25)

plt.savefig('graph_output/graph.png', transparent=True, bbox_inches='tight')