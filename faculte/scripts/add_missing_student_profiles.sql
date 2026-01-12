-- Add missing student profiles for existing student users
-- This script creates etudiants records for all student users who don't have one
INSERT INTO etudiants (user_id, numero_matricule)
SELECT u.id, CONCAT('MAT-', DATE_FORMAT(u.created_at, '%Y%m%d%H%i%s'))
FROM users u
LEFT JOIN etudiants e ON u.id = e.user_id
WHERE u.role = 'etudiant' AND e.id IS NULL;
