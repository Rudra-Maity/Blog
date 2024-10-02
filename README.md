# Blog Platform with User Authentication and Dashboard

## Project Overview

This project is a fully functional blog platform that allows users to sign up, log in, create, edit, and delete their own blog posts. It also includes a public-facing page where all published posts can be viewed. The platform uses PHP for server-side logic, MySQL for database storage, and JavaScript for enhanced user interactivity (e.g., auto-saving drafts). The application follows modern HTML5 and CSS standards, ensuring a polished and responsive user interface.

## Features

### 1. **User Authentication**
   - **Sign-Up and Login**:
     - Users can sign up by providing a username, email, and password.
     - Passwords are securely encrypted using `bcrypt`.
     - After logging in, users are redirected to their personalized dashboard.
   - **Session Management**:
     - Secure session handling is used to manage user authentication.
     - Unauthorized access to the dashboard is prevented.

### 2. **Dashboard**
   - Upon login, users are directed to their dashboard where they can:
     - View all their blog posts.
     - Create new posts, edit existing ones, or delete posts.
   - The dashboard is responsive and works on both desktop and mobile devices.

### 3. **Blog Creation and Editing**
   - Users can create and edit blog posts using a rich text editor (TinyMCE or Quill).
   - Blog post fields include:
     - Title (required)
     - Content (required)
     - Tags (optional)
   - Users can:
     - Save drafts.
     - Publish posts directly.
     - Edit and update their existing posts.

### 4. **Public Blog Display**
   - A public page displays all published blog posts.
   - Visitors can search posts by title, content, or tags.
   - Posts can be viewed by anyone, but only the original creator can edit or delete their own posts.

### 5. **Draft Auto-Save Feature**
   - An auto-save feature ensures drafts are saved at regular intervals or after user inactivity.
   - Drafts are stored in the database so users can return later to complete and publish their posts.

## Tech Stack

### **Backend**:
   - PHP: Handles server-side logic and user authentication.
   - MySQL: Stores user data, blog posts, and session information.
   - bcrypt: Password encryption for secure user authentication.

### **Frontend**:
   - HTML5/CSS3: For responsive and polished UI.
   - JavaScript: Handles interactivity, including auto-saving drafts.
   - TinyMCE/Quill: Rich text editor for creating and formatting blog content.
   - AJAX: Used for saving drafts without refreshing the page.

### **Libraries/Packages**:
   - TinyMCE or Quill: Rich text editor for blog post creation.
   - jQuery (optional): For handling AJAX requests and front-end interactivity.
   - Bootstrap (optional): For responsive layout and UI components.

## Installation

### 1. **Clone the Repository**:
   ```bash
   git clone https://github.com/Rudra-Maity/Blog.git
   cd blog-platform
