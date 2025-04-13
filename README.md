# 📬 Lead Submission API – Laravel

This is a Laravel-based API for submitting lead information via POST requests. The API is protected using token-based authentication and includes input validation and request/response logging.

## 🚀 Setup Instructions
Clone the repository:  
`git clone https://github.com/AlyssonSantos1/Aleatory.git`  
`cd Aleatory`

Install dependencies:  
`composer install`

Copy the example environment file and generate the application key:  
`cp .env.example .env`  
`php artisan key:generate`

Edit the `.env` file and set your database credentials and API token:  

DB_DATABASE=your_database DB_USERNAME=your_username DB_PASSWORD=your_password API_TOKEN=mytoken123


Run the migrations:  
`php artisan migrate`

Start the server:  
**Option A – Laravel’s built-in server:**  
`php artisan serve`

**Option B – Laragon (Apache):**  
Make sure Apache is running in Laragon and access the project at:  
`http://localhost/Aleatory/public`

## 🔐 Authentication
All API requests must include the following HTTP header:  
`API-TOKEN: mytoken123`

## 📤 Endpoint: POST /api/leads
Creates a new lead.

**Required Headers:**
- Content-Type: application/json
- API-TOKEN: mytoken123

**Request Body Example:**
```json
{
  "first_name": "Elton",
  "last_name": "Heaven",
  "email": "eltonh@email.com",
  "phone": "313-564-8207",
  "date_of_birth": "1996-07-14"
}


✅ Expected Responses
201 – Created

{
  "message": "Lead created successfully",
  "lead": {
    "first_name": "Elton",
    "last_name": "Heaven",
    "email": "eltonh@email.com",
    "phone": "313-564-8207",
    "date_of_birth": "1996-07-14",
    "created_at": "2025-04-12T00:00:00",
    "updated_at": "2025-04-12T00:00:00"
  }
}

401 – Unauthorized

{
  "error": "Unauthorized"
}

422 – Validation Errors

{
  "errors": {
    "email": [
      "The email has already been taken."
    ]
  }
}

500 – Internal Server Error
{
  "error": "Internal server error"
}

📌 Notes
The email field must be unique.

The date_of_birth field is optional but must be a valid date before today.

⚠️ Known Issues / Limitations
✅ Load Testing Note
During the load test using Artillery, the application encountered connection refusals when attempting to handle 60,000 requests per minute. This behavior suggests that Laravel's built-in development server (php artisan serve) is not suitable for handling such high throughput. In a production environment, this traffic would typically be managed using a more robust server like Apache or Nginx, possibly combined with queuing systems such as Redis to ensure scalability and performance.

This project was developed and tested using Laragon, which includes Apache pre-configured for local environments. Laragon is ideal for local development, but not designed for high-scale production-grade load tests.
