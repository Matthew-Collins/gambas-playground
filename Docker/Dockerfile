FROM ubuntu:bionic

RUN apt-get update 
RUN apt-get install -y software-properties-common
RUN apt-get update 
RUN add-apt-repository -y ppa:gambas-team/gambas3
RUN apt-get update
RUN apt-get install -y gambas3-scripter gambas3
RUN apt-get clean

COPY script.gbs script.gbs

CMD gbs3 script.gbs


