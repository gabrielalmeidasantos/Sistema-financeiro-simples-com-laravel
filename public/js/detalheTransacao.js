$("#detalhes").on("show.bs.modal", function (event) {
  var button = $(event.relatedTarget); // Botão que acionou o modal
  var valor = button.data("valor");
  var data = button.data("data"); // Extrai informação dos atributos data-*
  var descricao = button.data("descricao");
  // Se necessário, você pode iniciar uma requisição AJAX aqui e, então, fazer a atualização em um callback.
  // Atualiza o conteúdo do modal. Nós vamos usar jQuery, aqui. No entanto, você poderia usar uma biblioteca de data binding ou outros métodos.
  var modal = $(this);
  modal.find("#valor").text(valor);
  modal.find("#data").text(data);
  modal.find("#desc").text(descricao);
});
