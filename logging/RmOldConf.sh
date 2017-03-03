#!/bin/bash
if [ -d /var/log/phpm ]; then
rm -Rf /var/log/phpm 2> /dev/null
fi
if [ -f /etc/rsyslog.d/10-phpm.conf ]; then
rm -f /etc/rsyslog.d/10-phpm.conf 2> /dev/null
fi
if [ -f /etc/rsyslog.d/phpm.conf ]; then
rm -f /etc/rsyslog.d/phpm.conf 2> /dev/null
fi
systemctl restart rsyslog.service
systemctl restart apache2
