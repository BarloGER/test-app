# Full Stack App – Docker Setup

This project provides a **PHP backend** (server-side rendering possible) for basic login/register flows, a **Vite-based Frontend** in Vue/TypeScript, and a **MariaDB** database. Everything is containerized using **Docker** and **Docker Compose**, ensuring a straightforward setup. Follow the steps below to get an environment up and running, allowing you to register and log in with your newly created accounts.

---

## Table of Contents

1. [Overview](#overview)
2. [Requirements](#requirements)
3. [Getting Started](#getting-started)
    - [1. Start Containers with Docker Compose](#1-start-containers-with-docker-compose)
    - [2. Copy SQL Schema to the DB Container](#2-copy-sql-schema-to-the-db-container)
    - [3. Import SQL Schema in MariaDB](#3-import-sql-schema-in-mariadb)
    - [4. Access the Application](#4-access-the-application)

---

## Overview

1. **Frontend (Vite + Vue + TS)**
    - Runs on port **5173** (exposed on your host machine).
    - Provides a user interface for registration, login, and possibly other features.

2. **Backend (PHP + Apache)**
    - Runs on port **8080** (exposed on your host machine).
    - Handles server-side logic, serves PHP pages, processes login/register requests.

3. **Database (MariaDB)**
    - Runs on port **3306** (default for MySQL/MariaDB).
    - Stores user data in a `test_db` database.

These services communicate internally (Docker network) by service names (e.g., the PHP container calls the DB using hostname `db`). On your host machine, you access them via `localhost` and the mapped ports.

---

## Requirements

- **Docker** (recommended version 20 or higher)
- **Docker Compose** (v2.x or any recent version)

---

## Getting Started

Below are the essential steps to run the full stack app and set up the database schema.

### 1. Start Containers with Docker Compose

In your project directory (where `docker-compose.yml` is located), run:

```bash
docker-compose up -d
```

This command:

1. Builds or pulls the necessary images (Node for Vite, PHP + Apache, MariaDB).
2. Creates and starts the containers in the background.
3. Exposes:
    - **port 5173** for the Vite frontend container,
    - **port 8080** for the PHP-Apache container,
    - **port 3306** for the MariaDB container.

### 2. Copy SQL Schema to the DB Container

The repository includes an SQL file (e.g., `schema.sql`) to create the necessary database tables. For example, it might be located at `backend/db/schema.sql`. To copy it into the running **MariaDB container** named `mariadb`, execute:

```bash
docker cp backend/db/schema.sql mariadb:/schema.sql
```

### 3. Import SQL Schema in MariaDB

1. **Access the DB container**:

   ```bash
   docker exec -it mariadb bash
   ```

   This opens a shell **inside** the MariaDB container.


2. **Open the MariaDB CLI**:

   ```bash
   mariadb -u root -p
   ```
    - The **root password** is set to `rootpass` in `docker-compose.yml`.


3. **Select the database** and **import** the schema:
   ```sql
   USE test_db;
   SOURCE schema.sql;
   ```
    - `USE test_db;` selects the database created via environment variables.
    - `SOURCE schema.sql;` executes the statements in `schema.sql`.


4. **Verify** the tables:

   ```sql
   SHOW TABLES;
   ```
   If you see your `users` table (or whichever tables you defined), the import was successful.

### 4. Access the Application

1. **Frontend**:

    - Open your browser and navigate to:
      ```
      http://localhost:5173
      ```
    - This is your Vue + Vite app. If you have any forms or UI components that call the backend, they should point to `http://localhost:8080/...` endpoints.


2. **Backend (PHP)**:

    - If you need to directly access any PHP-served page, open:
      ```
      http://localhost:8080
      ```
    - This is the Apache + PHP container, which can handle requests or serve server-side rendered pages.
