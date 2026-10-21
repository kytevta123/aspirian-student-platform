const configuredApiBase = import.meta.env.VITE_API_BASE_URL;

export const API_BASE_URL =
  configuredApiBase ||
  (import.meta.env.DEV
    ? '/api'
    : 'https://api-student.aspirian.pk/api');

export const API_ROOT_URL = API_BASE_URL.replace(/\/api\/?$/, '');
export const SCHOOL_ID = import.meta.env.VITE_SCHOOL_ID || '1';

export function apiRequest(path, options = {}) {
  const headers = new Headers(options.headers || {});
  headers.set('Accept', 'application/json');

  return fetch(`${API_BASE_URL}${path}`, {
    ...options,
    credentials: 'include',
    headers,
  });
}

export function xsrfHeaders() {
  const cookie = document.cookie
    .split('; ')
    .find((part) => part.startsWith('XSRF-TOKEN='));

  return cookie
    ? { 'X-XSRF-TOKEN': decodeURIComponent(cookie.slice('XSRF-TOKEN='.length)) }
    : {};
}