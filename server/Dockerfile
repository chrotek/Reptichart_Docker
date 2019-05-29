# server Dockerfile
FROM python:3

ADD reptichart_server.py /
ADD config.ini /

EXPOSE 65432 65433 65434 65435 65436

CMD [ "python", "/reptichart_server.py" ]
# CMD [ "ls" ]

# ENTRYPOINT ["python", "/reptichart_server.py" ]
