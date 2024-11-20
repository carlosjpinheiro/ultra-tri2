// Função de validação para campo obrigatório
export const requiredRule = (value) => {
    return !!value || 'Este campo é obrigatório';
};
  
  // Função de validação para email válido
export const emailRule = (value) => {
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return emailRegex.test(value) || 'Digite um email válido';
};