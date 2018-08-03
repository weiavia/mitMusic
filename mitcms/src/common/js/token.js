export function saveToken(tokne) {
  window.localStorage.cmsToken = tokne;
}

export function getToken() {
  return window.localStorage.cmsToken;
}

export function clearToken() {
  window.localStorage.cmsToken = null;
}