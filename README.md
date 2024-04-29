![image](https://github.com/Ghanem99/Employment-Management-with-Filament/assets/93198762/adcf14ef-1bca-45a0-9f2a-71c50074aa50)

```markdown
# Employee Management System

This project is a simple Employee Management System built using Laravel Filament.
It provides a dashboard interface for managing employees and an API for listing all employees' data.

## Features

- Dashboard interface for managing employees
- API for listing all employees' data
```


## Installation

1. Clone the repository:

```bash
git clone https://github.com/your-username/employee-management-system.git
```

2. Navigate into the project directory:

```bash
cd employee-management-system
```

3. Install composer dependencies:

```bash
composer install
```

4. Create a `.env` file by copying the `.env.example` file:

```bash
cp .env.example .env
```

5. Generate an application key:

```bash
php artisan key:generate
```

6. Configure your database connection in the `.env` file:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. Run the database migrations:

```bash
php artisan migrate
```

8. Start the development server:

```bash
php artisan serve
```

## Usage

- Access the dashboard by visiting `http://localhost:8000/admin`
- Access the API for listing all employees' data:

```bash
GET /api/employees
```

## License

This project is open-source and available under the [MIT License](LICENSE).
```
