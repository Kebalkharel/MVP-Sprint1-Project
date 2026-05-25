<?php
require 'auth.php';
include 'header.php';
?>

<div class="container">

    <h1 class="page-title">Project Risk Register</h1>

    <table class="history-table">

        <thead>
            <tr>
                <th>Risk</th>
                <th>Impact</th>
                <th>Mitigation Strategy</th>
            </tr>
        </thead>

        <tbody>

            <tr>
                <td>Unauthorized access to student accounts</td>
                <td>Medium</td>
                <td>
                    Password hashing, session authentication,
                    protected pages and secure login validation.
                </td>
            </tr>

            <tr>
                <td>Database failure or data loss</td>
                <td>Medium</td>
                <td>
                    Regular database backup and phpMyAdmin export.
                </td>
            </tr>

            <tr>
                <td>Duplicate event registrations</td>
                <td>Medium</td>
                <td>
                    Validation checks before registration.
                </td>
            </tr>

            <tr>
                <td>Low student engagement</td>
                <td>Medium</td>
                <td>
                    Reward points system and cultural shop incentives.
                </td>
            </tr>

            <tr>
                <td>Transport information becoming outdated</td>
                <td>Medium</td>
                <td>
                    Live transport updates and Google Maps integration.
                </td>
            </tr>

            <tr>
                <td>System performance issues</td>
                <td>Medium</td>
                <td>
                    Optimized database queries and responsive design.
                </td>
            </tr>

        </tbody>

    </table>

</div>

<?php include 'footer.php'; ?>x	