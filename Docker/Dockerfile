FROM ubuntu:bionic

RUN apt-get update 
RUN apt-get install -y software-properties-common
RUN apt-get update 
RUN add-apt-repository -y ppa:gambas-team/gambas3
RUN apt-get update
RUN apt-get install -y gambas3-scripter gb.args gb.clipper gb.complex gb.compress gb.data gb.eval gb.eval.highlight gb.image.effect gb.image gb.inotify gb.markdown gb.option gb.settings gb.signal gb.util gb.util.web gb.vb gb.xml gb.xml.html 
RUN apt-get clean

COPY script.gbs script.gbs

CMD gbs3 script.gbs


