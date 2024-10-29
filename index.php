<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Registration System</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        #search, #classList, #registeredClasses {
            display: none;
        }
        /* Modal styling */
        #registeredClasses {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 90%;
            width: 400px;
            z-index: 10;
        }
        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 5;
            display: none;
        }
        /* Additional spacing */
        form {
            margin-bottom: 20px;
        }
        button {
            margin-top: 10px; /* Add space above buttons */
        }
    </style>
</head>
<body>

    <!-- Login Section -->
    <section id="login">
        <h2>Login</h2>
        <form id="loginForm">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Login</button>
        </form>
    </section>

    <!-- Course Search Section -->
    <section id="search">
        <h2>Search fo Classes</h2>
        <form id="searchForm">
            <label for="majorFilter">Major:</label>
            <select id="majorFilter" name="majorFilter">
                <option value="">Select Major</option>
                <option value="computer-science">Computer Science</option>
                <option value="business">Business</option>
                <option value="engineering">Engineering</option>
            </select>

            <label for="courseSearch">Course Code or Name:</label>
            <input type="text" id="courseSearch" name="courseSearch" placeholder="Enter course code or name">

            <button type="button" onclick="displayClasses()">Search Classes</button>
        </form>
    </section>

    <!-- Class List Section -->
    <section id="classList">
        <h2>Available Classes</h2>
        <form id="classSelectionForm">
            <div id="classesContainer"></div>
            <button type="submit" onclick="registerClasses(event)">Register for Selected Classes</button>
        </form>
        <button onclick="showRegisteredClasses()">View Registered Classes</button>
    </section>

    <!-- Overlay and Registered Classes Modal -->
    <div id="overlay"></div>
    <section id="registeredClasses">
        <h2>Registered Classes</h2>
        <div id="registeredClassesList"></div>
        <button onclick="closeRegisteredClasses()">Close</button>
    </section>

    <script>
        // Login functionality
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault();
            
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            const validUsername = 'admin';
            const validPassword = 'password123';

            if (username === validUsername && password === validPassword) {
                document.getElementById('login').style.display = 'none';
                document.getElementById('search').style.display = 'block';
            } else {
                alert('Invalid credentials. Please try again.');
            }
        });

        // Define classes with time slots for each major
        const classes = {
            'computer-science': [
                { code: 'CS101', name: 'Introduction to Programming', time: '09:00 - 10:30' },
                { code: 'CS201', name: 'Data Structures', time: '11:00 - 12:30' },
                { code: 'CS301', name: 'Algorithms', time: '10:00 - 11:30' }
            ],
            'business': [
                { code: 'BUS101', name: 'Introduction to Business', time: '09:00 - 10:30' },
                { code: 'BUS201', name: 'Marketing Principles', time: '11:00 - 12:30' },
                { code: 'BUS301', name: 'Finance Basics', time: '13:00 - 14:30' }
            ],
            'engineering': [
                { code: 'ENG101', name: 'Engineering Mechanics', time: '09:30 - 11:00' },
                { code: 'ENG201', name: 'Thermodynamics', time: '10:30 - 12:00' },
                { code: 'ENG301', name: 'Fluid Dynamics', time: '14:00 - 15:30' }
            ]
        };

        let registeredClasses = [];

        function displayClasses() {
            const selectedMajor = document.getElementById('majorFilter').value;
            const courseSearch = document.getElementById('courseSearch').value.toLowerCase();
            const classesContainer = document.getElementById('classesContainer');

            classesContainer.innerHTML = '';
            let filteredClasses = [];

            if (selectedMajor && classes[selectedMajor]) {
                filteredClasses = classes[selectedMajor];
            } else if (courseSearch) {
                for (const major in classes) {
                    filteredClasses = filteredClasses.concat(
                        classes[major].filter(
                            cls => cls.code.toLowerCase().includes(courseSearch) || cls.name.toLowerCase().includes(courseSearch)
                        )
                    );
                }
            }

            if (filteredClasses.length > 0) {
                filteredClasses.forEach(cls => {
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.id = cls.code;
                    checkbox.name = 'classes';
                    checkbox.value = cls.code;

                    checkbox.addEventListener('change', (event) => {
                        if (event.target.checked && !registeredClasses.some(item => item.code === cls.code)) {
                            registeredClasses.push(cls);
                        } else {
                            registeredClasses = registeredClasses.filter(item => item.code !== cls.code);
                        }
                    });

                    const label = document.createElement('label');
                    label.htmlFor = cls.code;
                    label.textContent = `${cls.code} - ${cls.name} (${cls.time})`;

                    const lineBreak = document.createElement('br');

                    classesContainer.appendChild(checkbox);
                    classesContainer.appendChild(label);
                    classesContainer.appendChild(lineBreak);
                });

                document.getElementById('classList').style.display = 'block';
            } else {
                document.getElementById('classList').style.display = 'none';
                alert('No classes found for your search.');
            }
        }

        function registerClasses(event) {
            event.preventDefault(); // Prevent form submission

            if (registeredClasses.length > 0) {
                alert('Successfully registered for selected classes!');
                // Here you might want to clear the registeredClasses array if needed
                // registeredClasses = [];
            } else {
                alert('Please select classes to register.');
            }
        }

        function showRegisteredClasses() {
            const registeredClassesList = document.getElementById('registeredClassesList');
            registeredClassesList.innerHTML = '';

            if (registeredClasses.length > 0) {
                registeredClasses.forEach(cls => {
                    const classItem = document.createElement('p');
                    classItem.textContent = `${cls.code} - ${cls.name} (${cls.time})`;
                    registeredClassesList.appendChild(classItem);
                });
            } else {
                registeredClassesList.textContent = 'No classes registered.';
            }

            document.getElementById('overlay').style.display = 'block';
            document.getElementById('registeredClasses').style.display = 'block';
        }

        function closeRegisteredClasses() {
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('registeredClasses').style.display = 'none';
        }
    </script>

</body>
</html>

