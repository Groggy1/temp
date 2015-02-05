#!/bin/bash
# a script to read and save temperature readings from all the group 28 1-wire temperature sensors
#
# Add this script to crontab (crontab -e, */2 * * * * /path/to/file/measure.sh) for measurement every second minute
# 
# get all devices in the '28' family

FILES=`ls /sys/bus/w1/devices/w1_bus_master1/ | grep '^28'`

#Iterte through all devices
for file in $FILES
do
	GETDATA=`cat /sys/bus/w1/devices/w1_bus_master1/$file/w1_slave`
	GETDATA1=`echo "$GETDATA" | grep crc`
	GETDATA2=`echo "$GETDATA" | grep t=`
	TEMP=`echo "$GETDATA2" | sed -n 's/.*t=//;p'`

	# test if crc is 'YES' and temperature is not -62 or +85
        if [ `echo $GETDATA1 | sed 's/^.*\(...\)$/\1/'` == "YES" -a $TEMP != "-62" -a $TEMP != "85000"  ]
           then
               # crc is 'YES' and temperature is not -62 or +85 - so save result
		mysql --host=localhost --user=root --password=abc123 termometer << EOF
		INSERT INTO measurement (sensorID, added, measurement) VALUES ('$file', NOW(), '$TEMP'/1000);
EOF
	fi
done
