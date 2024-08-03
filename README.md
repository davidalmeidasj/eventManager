# Event Controller Project

## Overview
This project is a php 7 project with docker and mysql

## Features
- Manage your Events

## Getting Started

### Prerequisites
- Docker and Docker Compose installed

#### Installation docker
1. Update packages
   ```bash
    sudo apt-get update
    sudo apt-get install apt-transport-https ca-certificates curl gnupg lsb-release


2. Add official docker gpg key:
   ```bash
    curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg

3. Set docker repo:
   ```bash
    echo "deb [arch=amd64 signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null


4. Update and install docker:
   ```bash
    sudo apt-get update
    sudo apt-get install docker-ce docker-ce-cli containerd.io


5. Check docker version:
   ```bash
    docker --version


#### Installation docker-compose
1. Download docker-compose
   ```bash
   sudo curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose 

2. Apply permission to execute:
   ```bash
    sudo chmod +x /usr/local/bin/docker-compose

3. Check docker-compose version:
   ```bash
    docker-compose --version

### Installation
1. Clone the repository or download zip:
   ```bash
   git clone <repository_url>
   cd <project>

2. Build and run the Docker containers:
   ```bash
   docker-compose build
   docker-compose up -d


###Project details
- `client/`: When starting docker for the first time, you may experience a delay in loading http://localhost:8080/

### Usage
- Use the frontend interface to create, edit and cancel your events
## Applications urls
- The main application:

   ```bash
   http://localhost:8080/

### Useful Commands
- Run tests:

   ```bash
   composer run-script test

- Stop and Remove Containers:

   ```bash
   docker-compose down

- Check Container Logs:

   ```bash
   docker-compose logs <service>

- Examples

    ```bash
    docker-compose logs web
- List Running Containers

    ```bash
    docker ps


