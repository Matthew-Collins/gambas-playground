FROM debian:stretch

RUN apt-get update && \
    apt-get install -y gambas3-script gb.args gb.clipper gb.complex gb.compress gb.data gb.eval gb.eval.highlight gb.image.effect gb.image gb.inotify gb.markdown gb.option gb.settings gb.signal gb.util gb.util.web gb.vb gb.xml gb.xml.html && \
    apt-get clean

COPY script.gbs script.gbs

CMD gbs3 script.gbs


