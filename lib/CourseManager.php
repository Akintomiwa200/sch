<?php
/**
 * Course Management System
 * Handles all course-related operations
 */
class CourseManager {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Create New Course
     * @param array $courseData
     * @return int Course ID
     * @throws Exception
     */
    public function createCourse(array $courseData): int {
        $required = ['course_name', 'course_info', 'course_category', 'instructor_id'];
        foreach ($required as $field) {
            if (empty($courseData[$field])) {
                throw new Exception("Missing required field: $field");
            }
        }

        try {
            $stmt = $this->db->prepare("
                INSERT INTO courses 
                (course_name, course_info, course_category, instructor_id, created_at)
                VALUES (?, ?, ?, ?, NOW())
            ");

            $stmt->execute([
                $courseData['course_name'],
                $courseData['course_info'],
                $courseData['course_category'],
                $courseData['instructor_id']
            ]);

            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception("Course creation failed: " . $e->getMessage());
        }
    }

    /**
     * Update Existing Course
     * @param int $courseId
     * @param array $updateData
     * @return bool
     * @throws Exception
     */
    public function updateCourse(int $courseId, array $updateData): bool {
        $allowedFields = ['course_name', 'course_info', 'course_category'];
        $updates = [];
        $params = [];

        foreach ($updateData as $field => $value) {
            if (in_array($field, $allowedFields)) {
                $updates[] = "$field = ?";
                $params[] = $value;
            }
        }

        if (empty($updates)) {
            throw new Exception("No valid fields to update");
        }

        $params[] = $courseId;

        try {
            $stmt = $this->db->prepare("
                UPDATE courses 
                SET " . implode(', ', $updates) . " 
                WHERE course_id = ?
            ");
            
            return $stmt->execute($params);
        } catch (PDOException $e) {
            throw new Exception("Course update failed: " . $e->getMessage());
        }
    }

    /**
     * Delete Course
     * @param int $courseId
     * @return bool
     * @throws Exception
     */
    public function deleteCourse(int $courseId): bool {
        try {
            $stmt = $this->db->prepare("
                DELETE FROM courses 
                WHERE course_id = ?
            ");
            return $stmt->execute([$courseId]);
        } catch (PDOException $e) {
            throw new Exception("Course deletion failed: " . $e->getMessage());
        }
    }

    /**
     * Get Courses by Instructor
     * @param int $instructorId
     * @return array
     */
    public function getCoursesByInstructor(int $instructorId): array {
        $stmt = $this->db->prepare("
            SELECT c.*, i.name AS instructor_name 
            FROM courses c
            JOIN instructors i ON c.instructor_id = i.id
            WHERE c.instructor_id = ?
        ");
        $stmt->execute([$instructorId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get Course Details
     * @param int $courseId
     * @return array|null
     */
    public function getCourseDetails(int $courseId): ?array {
        $stmt = $this->db->prepare("
            SELECT c.*, i.name AS instructor_name 
            FROM courses c
            JOIN instructors i ON c.instructor_id = i.id
            WHERE c.course_id = ?
        ");
        $stmt->execute([$courseId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * List All Courses (Public View)
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function listAllCourses(int $limit = 10, int $offset = 0): array {
        $stmt = $this->db->prepare("
            SELECT c.*, i.name AS instructor_name 
            FROM courses c
            JOIN instructors i ON c.instructor_id = i.id
            ORDER BY c.created_at DESC
            LIMIT ? OFFSET ?
        ");
        $stmt->execute([$limit, $offset]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}