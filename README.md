# Task Management System

## Description

Create a simple task management application using PHP and MySQL. This application should allow users to:

- **Create Tasks**: Users can add new tasks with a title, description, due date, and status (pending/completed).
- **View Task List**: Users can view all created tasks in a table format.
- **Edit Tasks**: Users can edit the details of existing tasks.
- **Delete Tasks**: Users can delete tasks from the list.
- **Change Task Status**: Users can toggle the status of a task between pending and completed.

## Technical Specifications

### Database

- Create a MySQL database named `task_manager`.
- Create a table `tasks` with the following structure:

```sql
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    due_date DATE NOT NULL,
    status ENUM('pending', 'completed') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Main Features

#### Add Task Page

- A form to input the title, description, and due date.
- A button to save the task.

#### Task List Page

- A table displaying all tasks with their details.
- Buttons to edit, delete, and change the status of tasks.

#### Edit Task Page

- A form pre-filled with the details of the task to be edited.
- A button to save the changes.

### Backend Logic

- Use PHP to handle CRUD (Create, Read, Update, Delete) operations in the database.

## Additional Requirements

- **Input Validation**: Ensure all entered data is valid.
- **Notification Messages**: Display messages (e.g., "Task successfully added", "Task successfully deleted") after operations.
- **Use PDO**: Use PDO to interact with the database to prevent SQL injection.
- **Project Structure**: Maintain a clean project structure with a separation of business logic and presentation (use a simple MVC pattern if possible).

---

This description provides a clear and structured overview of the project, suitable for a GitHub README.
