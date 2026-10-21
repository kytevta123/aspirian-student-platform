export const PERFORMANCE_OPTIONS = [
  { value: '', label: 'All Performance' },
  { value: 'excellent', label: 'Excellent' },
  { value: 'good', label: 'Good' },
  { value: 'average', label: 'Average' },
  { value: 'needs-improvement', label: 'Needs Improvement' },
];

export const STATUS_OPTIONS = [
  { value: '', label: 'All Status' },
  { value: 'completed', label: 'Completed' },
];

export function getPerformanceKey(average) {
  const score = Number(average) || 0;

  if (score >= 90) return 'excellent';
  if (score >= 80) return 'good';
  if (score >= 70) return 'average';

  return 'needs-improvement';
}

function normalize(value) {
  return String(value ?? '').trim().toLowerCase();
}

function getClassNumber(className) {
  const value = normalize(className);

  if (value === 'nursery') return 0;
  if (value === 'kg' || value === 'kindergarten') return 0.5;

  const match = value.match(/(\d+)/);

  return match ? Number(match[1]) : null;
}

function getClassRange(value) {
  const normalized = normalize(value);

  if (!normalized) {
    return null;
  }

  /*
   * Examples:
   * Nursery
   * KG
   * 9th Class
   * 6th - 12th
   * Nursery - 5th
   * 1st - 10th
   */

  const parts = normalized
    .split(/\s*[-–]\s*/)
    .map((part) => part.trim())
    .filter(Boolean);

  if (parts.length === 2) {
    const min = getClassNumber(parts[0]);
    const max = getClassNumber(parts[1]);

    if (min !== null && max !== null) {
      return {
        min: Math.min(min, max),
        max: Math.max(min, max),
      };
    }
  }

  const singleNumber = getClassNumber(normalized);

  if (singleNumber !== null) {
    return {
      min: singleNumber,
      max: singleNumber,
    };
  }

  return null;
}

export function classMatches(selectedClass, value) {
  if (!selectedClass || !value) {
    return true;
  }

  const selectedNumber = getClassNumber(selectedClass);

  if (selectedNumber === null) {
    return normalize(value).includes(normalize(selectedClass));
  }

  const range = getClassRange(value);

  if (!range) {
    return normalize(value).includes(normalize(selectedClass));
  }

  return selectedNumber >= range.min && selectedNumber <= range.max;
}

export function matchesSearch(item, searchFields, search) {
  if (!search) {
    return true;
  }

  const query = normalize(search);

  return searchFields.some((field) =>
    normalize(item[field]).includes(query)
  );
}

export function matchesPerformance(average, selectedPerformance) {
  if (!selectedPerformance) {
    return true;
  }

  return getPerformanceKey(average) === selectedPerformance;
}

export function matchesSubject(
  item,
  selectedSubject,
  subjectFields = ['subject', 'name']
) {
  if (!selectedSubject) {
    return true;
  }

  const selected = normalize(selectedSubject);

  return subjectFields.some((field) =>
    normalize(item[field]).includes(selected)
  );
}

export function matchesStatus(item, selectedStatus) {
  if (!selectedStatus) {
    return true;
  }

  return normalize(item.status) === normalize(selectedStatus);
}

export function filterStudentReports(data, filters) {
  return data.filter(
    (student) =>
      matchesSearch(
        student,
        ['name', 'studentId', 'className', 'subject'],
        filters.search
      ) &&
      classMatches(filters.selectedClass, student.className) &&
      matchesSubject(student, filters.selectedSubject, ['subject']) &&
      matchesPerformance(student.average, filters.performance)
  );
}

export function filterClassReports(data, filters) {
  return data.filter(
    (classItem) =>
      matchesSearch(classItem, ['name', 'section'], filters.search) &&
      classMatches(filters.selectedClass, classItem.name) &&
      matchesPerformance(classItem.average, filters.performance)
  );
}

export function filterSubjectReports(data, filters) {
  return data.filter(
    (subject) =>
      matchesSearch(subject, ['name', 'classes'], filters.search) &&
      classMatches(filters.selectedClass, subject.classes) &&
      matchesSubject(subject, filters.selectedSubject, ['name']) &&
      matchesPerformance(subject.average, filters.performance)
  );
}

export function filterTestReports(data, filters) {
  return data.filter(
    (test) =>
      matchesSearch(
        test,
        ['title', 'className', 'subject', 'status'],
        filters.search
      ) &&
      classMatches(filters.selectedClass, test.className) &&
      matchesSubject(test, filters.selectedSubject, ['subject']) &&
      matchesPerformance(test.average, filters.performance) &&
      matchesStatus(test, filters.status)
  );
}