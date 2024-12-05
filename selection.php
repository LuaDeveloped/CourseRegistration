<?php
    session_start();
    include "database.php";
    // Assuming the $username and $password are already set (e.g., from the session or request)
    $sql = "SELECT * FROM Student WHERE EMAIL = ? AND Password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $_SESSION["email"], $_SESSION["password"]); // Bind the username and password parameters
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    // Check if we got a result
    if ($result->num_rows > 0) {
        // Fetch the row as an associative array
        $row = $result->fetch_assoc();
        $Fname = $row['FirstName']; // Retrieve the 'FirstName' from the row
        $Lname = $row['Lastname']; // Retrieve the 'FirstName' from the row
        $SID = $row['StudentID']; // Retrieve the 'FirstName' from the row
        $GPA = $row['GPA']; // Retrieve the 'FirstName' from the row
        $major = $row['MajorID']; 
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Classes - Course Registration System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <section id="selection">
        <h2>Select Classes</h2>

        <!-- Student Information Section -->
        <div class="student-info">
            <h3>Student Information</h3>
            <p><strong>Name:</strong><?php echo "$Fname $Lname" ?></p>
            <p><strong>Student ID:</strong><?php echo "$SID" ?></p>
            <p><strong>GPA:</strong><?php echo "$GPA" ?></p>
            <p><strong>Major:</strong><?php echo "$major" ?></p>
            <p><strong>Standing:</strong><?php echo "" ?></p>
            <p><strong>Credits Earned:</strong> <span id="studentCredits">N/A</span></p>
        </div>

        <!-- Course Search Filters -->
        <form id="searchForm">
            <label for="majorFilter">Major:</label>
            <select id="majorFilter">
                <option value="">Select Major</option>
                <option value="computer-science">Computer Science</option>
                <option value="business-administration">Business Administration</option>
                <option value="mechanical-engineering">Mechanical Engineering</option>
            </select>

            <label for="courseSearch">Course Code or Name:</label>
            <input type="text" id="courseSearch" placeholder="Enter course code or name">
            <button type="button" onclick="displayClasses()">Search Classes</button>
        </form>

        <h3>Available Classes</h3>
        <div id="classesContainer"></div>
        <button onclick="registerSelectedClasses()" disabled>Register Selected Classes</button>
        <button onclick="window.location.href='home.php'">Back to Home</button>
    </section>

    <script>
        const classes = {
            'computer-science': [
                { code: 'CS1200', name: 'Introduction to Computer Science', time: '9:00 - 10:30' },
                { code: 'CS1300', name: 'Computer Science I', time: '9:30 - 11:00' },
                { code: 'CS1350', name: 'Computer Science II', time: '11:00 - 12:30' },
                { code: 'CS1500', name: 'Introduction to Server Systems', time: '1:00 - 2:30' },
                { code: 'CS2100', name: 'Introduction to Computer Systems', time: '2:00 - 3:30' },
                { code: 'CS2500', name: 'Database Systems', time: '10:00 - 11:30' },
                { code: 'CS3200', name: 'Operating Systems', time: '11:30 - 13:00' },
                { code: 'CS3500', name: 'Numerical Methods', time: '3:00 - 4:30' },
                { code: 'CS3700', name: 'Object Orientation', time: '9:00 - 10:30' },
                { code: 'CS3800', name: 'Data Structures & Algorithms', time: '12:00 - 1:30' },
                { code: 'CS4000', name: 'Computer Science Seminar', time: '4:00 - 5:30' },
                { code: 'CS4500', name: 'Software Engineering', time: '10:00 - 11:30' },
                { code: 'CS4600', name: 'Organization of Programming', time: '09:30 - 11:00' },
                { code: 'CS4800', name: 'Systems Software', time: '2:30 - 4:00' }
            ],
            'Business-Administration': [
                { code: 'BA2010', name: 'Principles of Management', time: '8:00 - 9:30' },
                { code: 'BA2020', name: 'Operations Management', time: '9:30 - 11:00' },
                { code: 'BA2200', name: 'Personal Finance', time: '10:00 - 11:30' },
                { code: 'BA2410', name: 'Human Resources Management', time: '12:00 - 1:30' },
                { code: 'BA2500', name: 'Marketing', time: '11:00 - 12:30' },
                { code: 'BA2700', name: 'Organizational Behavior', time: '2:00 - 3:30' },
                { code: 'BA3080', name: 'Ethical and Legal Decision-Making', time: '3:00 - 4:30' },
                { code: 'BA3090', name: 'Global Business and Leadership', time: '8:30 - 10:00' },
                { code: 'BA4910', name: 'Business Policy/Strategic Planning', time: '10:30 - 12:00' },
            ],
            'Mechanical-Engineering':[
                { code: 'CH1220', name: 'General Chemistry I', time: '8:00 AM - 9:30 AM', credits: 3 },
                { code: 'ECE2100', name: 'Circuit Analysis I', time: '9:45 AM - 11:15 AM', credits: 3 },
                { code: 'EGR1500', name: 'Computer Programming for Engineers', time: '11:30 AM - 1:00 PM', credits: 3 },
                { code: 'EGR1710', name: 'Engineering Graphics and Design', time: '1:15 PM - 2:45 PM', credits: 3 },
                { code: 'EGR2600', name: 'Materials Science', time: '10:15 AM - 11:45 AM', credits: 3 },
                { code: 'EGR2650', name: 'Manufacturing Processes', time: '2:30 PM - 4:00 PM', credits: 3 },
                { code: 'EGR4400', name: 'Professional Practice', time: '4:15 PM - 5:45 PM', credits: 3 },
                { code: 'EGR4820', name: 'Computer Integrated Manufacturing', time: '9:00 AM - 10:30 AM', credits: 2 },
                { code: 'EM2010', name: 'Statics', time: '11:00 AM - 12:30 PM', credits: 3 },
                { code: 'EM2020', name: 'Dynamics', time: '1:00 PM - 2:30 PM', credits: 3 },
                { code: 'EM2700', name: '3D CAD Parametric Modeling', time: '3:00 PM - 4:30 PM', credits: 3 },
                { code: 'EM3100', name: 'Mechanics of Materials', time: '8:30 AM - 10:00 AM', credits: 3 },
                { code: 'EM3150', name: 'Mechanics of Materials Lab', time: '10:15 AM - 11:45 AM', credits: 1 },
                { code: 'EM3500', name: 'Fluid Mechanics', time: '12:45 PM - 2:15 PM', credits: 3 },
                { code: 'EM3550', name: 'Fluid Mechanics Lab', time: '2:30 PM - 4:00 PM', credits: 1 },
                { code: 'MA1210', name: 'Calculus II', time: '10:30 AM - 12:00 PM', credits: 4 },
                { code: 'MA2100', name: 'Differential Equation & Linear Algebra', time: '1:15 PM - 2:45 PM', credits: 4 },
                { code: 'MA2200', name: 'Calculus III', time: '9:00 AM - 10:30 AM', credits: 4 },
                { code: 'MA2430', name: 'Probability & Statistics for Engineers', time: '11:45 AM - 1:15 PM', credits: 3 },
                { code: 'ME3110', name: 'Theory of Machines', time: '2:00 PM - 3:30 PM', credits: 3 },
                { code: 'ME3200', name: 'Thermodynamics I', time: '8:00 AM - 9:30 AM', credits: 3 },
                { code: 'ME3400', name: 'Mechanical Engineering Design I', time: '3:15 PM - 4:45 PM', credits: 3 },
                { code: 'ME3405', name: 'Finite Element Analysis', time: '12:30 PM - 2:00 PM', credits: 1 },
                { code: 'ME4200', name: 'Thermal Science Investigations', time: '9:15 AM - 10:45 AM', credits: 3 },
                { code: 'ME4250', name: 'Thermal Science Investigations Lab', time: '11:30 AM - 1:00 PM', credits: 1 },
                { code: 'ME4300', name: 'Heat Transfer', time: '1:30 PM - 3:00 PM', credits: 3 },
                { code: 'ME4310', name: 'Heat Transfer Lab', time: '3:30 PM - 5:00 PM', credits: 1 },
                { code: 'ME4400', name: 'Mechanical Engineering Design II', time: '8:45 AM - 10:15 AM', credits: 3 },
                { code: 'ME4960', name: 'ME Senior Project I', time: '10:30 AM - 12:00 PM', credits: 2 },
                { code: 'ME4961', name: 'ME Senior Project II', time: '1:45 PM - 3:15 PM', credits: 2 },
                { code: 'PH1300', name: 'General Physics I', time: '11:15 AM - 12:45 PM', credits: 3 },
                { code: 'PH1310', name: 'General Physics I Laboratory', time: '2:15 PM - 3:45 PM', credits: 1 },
                { code: 'PH2300', name: 'General Physics II', time: '9:30 AM - 11:00 AM', credits: 3 },
                { code: 'PH2310', name: 'General Physics II Laboratory', time: '12:30 PM - 2:00 PM', credits: 1 }
                ]
    };

      // Function to check if two time slots overlap
      function isTimeOverlap(time1, time2) {
            const parseTime = (time) => {
                const [hours, minutes] = time.split(':');
                return parseInt(hours) * 60 + parseInt(minutes);
            };

            const [start1, end1] = time1.split(' - ').map(parseTime);
            const [start2, end2] = time2.split(' - ').map(parseTime);

            return (start1 < end2 && start2 < end1);
        }

        function displayClasses() {
            const selectedMajor = document.getElementById('majorFilter').value.toLowerCase();
            const courseSearch = document.getElementById('courseSearch').value.toLowerCase();
            const classesContainer = document.getElementById('classesContainer');
            const registerButton = document.querySelector('button[onclick="registerSelectedClasses()"]');
            classesContainer.innerHTML = '';
            registerButton.disabled = true;

            // Filter classes based on selected major
            if (!selectedMajor) {
                classesContainer.innerHTML = '<p>Please select a major to see available classes.</p>';
                return;
            }

            let filteredClasses = classes[selectedMajor] || [];

            // Further filter classes based on course search query
            if (courseSearch) {
                filteredClasses = filteredClasses.filter(
                    cls => cls.code.toLowerCase().includes(courseSearch) || cls.name.toLowerCase().includes(courseSearch)
                );
            }

            // Create class cards
            filteredClasses.forEach(cls => {
                const classCard = document.createElement('div');
                classCard.classList.add('class-card');
                classCard.innerHTML = `
                    <input type="checkbox" id="class-${cls.code}" class="class-select">
                    <label for="class-${cls.code}">${cls.code} - ${cls.name} (${cls.time})</label>
                `;
                classesContainer.appendChild(classCard);
            });

            // Add event listener to check for overlaps
            const checkboxes = document.querySelectorAll('.class-select');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', handleClassSelection);
            });
        }

        function handleClassSelection() {
            const selectedClasses = [];
            const checkboxes = document.querySelectorAll('.class-select:checked');
            
            checkboxes.forEach(checkbox => {
                const classCode = checkbox.id.split('-')[1];
                const selectedClass = classes['computer-science'].find(cls => cls.code === classCode)
                if (selectedClass) {
                    selectedClasses.push(selectedClass);
                }
            });

            const overlapError = document.querySelector('#overlapError');
            if (overlapError) overlapError.remove();

            // Check for time overlap
            let hasOverlap = false;
            for (let i = 0; i < selectedClasses.length; i++) {
                for (let j = i + 1; j < selectedClasses.length; j++) {
                    if (isTimeOverlap(selectedClasses[i].time, selectedClasses[j].time)) {
                        hasOverlap = true;
                        break;
                    }
                }
                if (hasOverlap) break;
            }

            if (hasOverlap) {
                const errorMsg = document.createElement('p');
                errorMsg.id = 'overlapError';
                errorMsg.style.color = 'red';
                errorMsg.textContent = 'There is a time overlap between selected classes.';
                document.getElementById('selection').appendChild(errorMsg);
            }

            // Enable register button if no overlap
            document.querySelector('button[onclick="registerSelectedClasses()"]').disabled = hasOverlap;
        }

        function registerSelectedClasses() {
            const selectedClasses = [];
            const checkboxes = document.querySelectorAll('.class-select:checked');

            checkboxes.forEach(checkbox => {
                const classCode = checkbox.id.split('-')[1];
                const selectedClass = classes['computer-science'].find(cls => cls.code === classCode);
                if (selectedClass) selectedClasses.push(selectedClass);
            });

            if (selectedClasses.length > 0) {
                // Store selected classes in localStorage
                let registeredClasses = JSON.parse(localStorage.getItem('registeredClasses')) || [];
                registeredClasses = [...registeredClasses, ...selectedClasses];
                localStorage.setItem('registeredClasses', JSON.stringify(registeredClasses));

                alert('Successfully registered for: ' + selectedClasses.map(cls => cls.name).join(', '));
            } else {
                alert('Please select at least one class.');
            }
        }

    </script>
</body>
</html>