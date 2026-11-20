const event = 'ultratri2027';

export async function submitAthleteRegistration(answers) {
  const response = await fetch('/site-api/v1/athlete-registrations', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ ...answers, event }),
  });
  let result;
  try {
    result = await response.json();
  } catch {
    throw new Error('Não foi possível conectar ao serviço de inscrições. Tente novamente mais tarde.');
  }
  if (!response.ok) {
    const firstError = Object.values(result.errors || {})[0];
    throw new Error(firstError || result.message || 'Erro ao enviar o formulário. Tente novamente.');
  }
}
