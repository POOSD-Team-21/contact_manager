const signInForm = document.querySelector('#sign-in-form');

signInForm.addEventListener('submit', async (e) => {
  // Prevent the default form submission behavior
  e.preventDefault();

  // Grab field values from the form
  const user = Object.fromEntries(new FormData(signInForm));

  const data = await signInUser(user);
  if (data.error) {
    console.log(data.error);
    return;
  }

  localStorage.setItem(
    'user',
    JSON.stringify({
      id: data.id,
    }),
  );

  // Redirect to the dashboard
  window.location.href = '/dashboard.html';
});

// TODO: implement
async function signInUser(user) {
  const res = await fetch('/api/sign-in.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(user),
  });
  return res.json();
}
