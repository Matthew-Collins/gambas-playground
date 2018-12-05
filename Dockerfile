FROM prokopyl/gambas-trunk

COPY playground-runner /usr/local/src/playground-runner
RUN gbc3 /usr/local/src/playground-runner && \
    gba3 /usr/local/src/playground-runner -o /usr/local/sbin/playground-runner

CMD ["/usr/local/sbin/playground-runner"]
