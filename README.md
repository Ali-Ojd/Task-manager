# SmartTask – Intelligent Task Manager

A full-stack task management application that uses machine learning to automatically categorize your tasks in real time.

## Why I built this
I wanted to combine web development with machine learning in a single, practical product. The goal was to move beyond tutorials and build something that demonstrates real system integration: user authentication, database design, and on-the-fly AI inference.

## What it does
- Users can register and log in securely (password hashing, sessions).
- Each user manages their own task list—no one else’s data is visible.
- When a user creates a task, the task text is sent to a Python ML model.
- The model (Logistic Regression, trained on 7,000 realistic task descriptions) predicts a category: Work, Personal, Shopping, Health, Finance, or Education.
- The predicted category and a confidence score are displayed immediately.

## Architecture
- **Frontend:** HTML, CSS, vanilla JavaScript
- **Backend:** PHP (procedural, with prepared statements for security)
- **Database:** MySQL (user and task tables, user-scoped queries)
- **ML Service:** Python script with a pre-trained scikit-learn model (Logistic Regression). PHP calls the script via `shell_exec` for real-time predictions.
- **Training data:** 7,000 hand-crafted realistic task examples, covering 6 categories.

## How to run it locally
1. Clone the repository
2. Import `database.sql` into your MySQL server
3. Update database credentials in `config.php`
4. Ensure Python 3 and the required packages (`scikit-learn`, `pandas`) are installed
5. Place the trained model file (`model.joblib`) in the `ml/` directory
6. Run a local PHP server (e.g., `php -S localhost:8000`)

## What I learned
- Integrating PHP and Python in a single request lifecycle
- The importance of user data isolation and secure password storage
- How to train a real text classifier and expose it to a web app
- Balancing practical features with security best practices (prepared statements, output escaping)

## Future improvements
- Replace `shell_exec` with a Python microservice (Flask/FastAPI) for better security and scalability
- Add task editing, deadlines, and reminders
- Deploy live for public access
