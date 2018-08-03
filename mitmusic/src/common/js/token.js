/**
 * Created by weiai on 2018/3/22.
 */
export function saveToken(tokne) {
  window.localStorage.token = tokne;
}

export function getToken() {
  return window.localStorage.token;
}

export function clearToken() {
  localStorage.removeItem('token')
}
