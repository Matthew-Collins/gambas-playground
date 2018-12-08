# To Run Server

Create and Login with service user (not Root otherwise will run as NoBody)

Add User to existing Docker Group:
sudo usermod -aG docker $USER

To Run WebApp on Port 8080:
GB_HTTPD_PORT=8080 gbr3 --httpd playground-server.gambas
