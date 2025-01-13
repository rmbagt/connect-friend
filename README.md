# ConnectFriend 👥

![ConnectFriend Logo](/public/assets/connectfriend.svg)

ConnectFriend is a social networking platform designed to help users connect with like-minded individuals based on shared hobbies and interests. It provides a fun and interactive way to make new friends and expand your social circle.

### Live Website

[ConnectFriend Live](https://connectfriend.rey.mba/)

---

## Tech Stack

![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)
![Bootstrap](https://img.shields.io/badge/bootstrap-%238511FA.svg?style=for-the-badge&logo=bootstrap&logoColor=white)
![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white)

1. **Laravel** as the backend framework.
2. **Bootstrap** for frontend styling and components.
3. **MySQL** as the database.

---

## Table of Contents

1. [Installation](#installation)
2. [Environment Setup](#environment-setup)
3. [Usage](#usage)
4. [Features](#features)
5. [Contributors](#contributors)

---

## Installation

### Prerequisites

-   PHP and Composer installed on your machine.
-   Node.js and npm installed for asset compilation.

### Steps

1. **Clone Repository:**

```bash
git clone https://github.com/reynaldomarchell/FinalASGWebProg-2602138214-ReynaldoMarchellBagasAdji.git
```

2. **Install PHP Dependencies:**

```shellscript
composer install
```

3. **Install JavaScript Dependencies:**

```shellscript
npm install
```

4. **Setup Database:**

Create a MySQL database and configure the connection in your `.env` file. Then run migrations + seeder:

```shellscript
php artisan migrate --seed
```

5. **Generate Key:**

```shellscript
php artisan key:generate
```

6. **Link Storage:**

```shellscript
 php artisan storage:link
```

7. **Compile Assets:**

```shellscript
npm run dev
```

8. **Start Development Server:**

```shellscript
php artisan serve
```

9. **Access Application:**

Open [http://localhost:8000/](http://localhost:8000/) in your browser.

---

## Environment Setup

Ensure you have a valid `.env` file with the following variables (replace placeholders with your actual values):

```plaintext
APP_NAME=ConnectFriend
APP_ENV=local
APP_KEY=YOUR_APP_KEY
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

---

## Usage

1. **Landing Page (/):** Browse and discover potential friends.
2. **Register (/register):** Create a new account.
3. **Login (/login):** Log in to your account.
4. **Home (/home):** View and interact with other users.
5. **Profile (/users/id):** View and edit your profile.
6. **Friends (/friends):** Manage your friendships.
7. **Messages (/messages):** Chat with your friends.
8. **Avatars (/avatars):** Purchase and set custom avatars.

---

## Features

-   **User Authentication:** Secure registration and login system.
-   **Profile Management:** Create and edit your profile with hobbies and interests.
-   **Friend System:** Add friends and manage your connections.
-   **Messaging:** Real-time chat with your friends.
-   **Discover:** Find potential friends based on shared interests.
-   **Wishlist:** Add users to your wishlist for potential future connections.
-   **Avatar Shop:** Purchase and use custom avatars.
-   **Wallet System:** Manage in-app currency for avatar purchases.
-   **Notifications:** Stay updated with friend requests and messages.

---

## Contributors

<a href="https://github.com/reynaldomarchell/FinalASGWebProg-2602138214-ReynaldoMarchellBagasAdji/graphs/contributors">
    <img src="https://contrib.rocks/image?repo=reynaldomarchell/FinalASGWebProg-2602138214-ReynaldoMarchellBagasAdji"/>
</a>
