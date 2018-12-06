FROM debian:stretch

RUN apt-get update && \
    apt-get install -y gambas3-script && \
    apt-get clean

COPY script.gbs script.gbs

CMD gbs3 script.gbs

