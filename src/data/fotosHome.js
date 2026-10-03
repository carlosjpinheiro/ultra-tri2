const arquivos = import.meta.glob('../assets/images/hero/*', { eager: true, as: 'url', import: 'default' });

// Adicionar fotos nesta pasta continua sendo suficiente para atualizar a galeria.
const fotosHome = Object.entries(arquivos)
  .filter(([nome]) => /\.(jpe?g|png|webp|avif|gif)$/i.test(nome))
  .sort(([a], [b]) => a.localeCompare(b, 'pt-BR', { numeric: true }))
  .map(([nome, src]) => ({ nome: nome.split('/').pop(), src }));

export { fotosHome };
