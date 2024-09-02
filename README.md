# E-Invoicing System

This repository contains the PHP code for an E-Invoicing System, designed to capture system information, handle form submissions, and save data to a MySQL database. The system is built to assist businesses in managing invoices efficiently, with a user-friendly interface and dynamic form behavior based on user input.

## Features

- **System Information Capture:** Automatically gathers and displays essential system information.
- **Dynamic Form Handling:** The form adjusts based on user selections, such as updating labels and displaying additional sections.
- **Database Integration:** Data is securely saved to a MySQL database (`e-invoicing`).
- **User-Friendly Interface:** The layout is designed with a professional appearance and ease of use in mind.

## Installation

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/yourusername/e-invoicing-system.git
   ```
2. **Set Up the Environment:**
   - Install [XAMPP](https://www.apachefriends.org/index.html) or any PHP and MySQL environment.
   - Import the database schema from `e-invoicing.sql` into your MySQL database.
3. **Configure the Database:**
   - Update the database configuration in the PHP files as needed.
4. **Run the Project:**
   - Place the project files in your web server's root directory.
   - Access the application via `http://localhost/your-project-directory`.

## Usage

1. **Auto System Capture:** The form will automatically populate certain fields with system information.
2. **User Input:** Users can fill out the form, which dynamically updates based on the type of ID selected.
3. **Data Submission:** On form submission, the data is saved to the `e-invoicing` database.

## Project Structure

- **`test5.php`:** Main PHP file for handling form submissions and system information capture.
- **`css/`:** Directory containing stylesheets for the project.
- **`js/`:** Directory containing JavaScript files for dynamic form behavior.
- **`e-invoicing.sql`:** Database schema for the `e-invoicing` database.

## Contribution

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is licensed under the MIT License.
