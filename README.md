# Event Controller Project

## Overview
This project is a php 7 project with docker and mysql

## Features
- Manage your Events

## Getting Started

### Prerequisites
- Docker and Docker Compose installed

### Installation
1. Clone the repository:
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


