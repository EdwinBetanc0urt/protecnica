$(function () {
    // Añadir un icono de flecha a todos los 'li' que tenga una lista en su interior.
    $('#main-menu > li').each(function (){
        // Recorre los 'li' del menú principal y verifica si tiene un elemento 'ul'
        if ($(this).children('ul').length > 0) {
            // Si existe procede a crear un nuevo elemento 'i'
            let elementI = document.createElement('i');
            // Le agrega las clases correspondiente para que tenga un fondo de flecha.
            $(elementI).addClass('fas fa-angle-right icon-right');
            // Obtenemos el elemento 'a' del elemento 'i';
            let link = $(this).children("a");
            // Y le agregamos el nuevo elemento creado 'i' al element 'a'.
            $(link).append(elementI);
        }
    });
    
    // Establecer un alto al documento si es menor al de la pantalla para que se ajuste el footer.
    setInterval(getHeight, 100);
    function getHeight ()
    {
        // Se remueven los estilos para que siempre se mantenga actualizada la pantalla.
        $("#main-container").removeAttr("style");
        // Obtenemos el alto del header
        let heightHeader = $(".header").height();
        // Obtenemos el alto del footer
        let heightFooter = $("footer").height();
        // Obtenemos el alto total del documento.
        let heightDocument = $(document).height();
        // Al total del documento se le resta el total del header y el footer para obtener el total
        // Que se le agregara al contenedor principal y todo quede ajustado correctamente.
        let total = heightDocument - (heightFooter + heightHeader);
        // Agregamos el nuevo alto al contenedor.
        $("#main-container").height(total);
    }
    
    // Expandir el submenu del li cuando sea clickeado u ocultarlo y agregar fondo de selección.
    $("#main-menu > li").click(function (){
        // Obtenemos el submenú 'ul' de li que hemos cliqueado.
        let submenu = $(this).children("ul");
        // Se obtiene el elemento 'a'
        let link    = $(this).children("a");
        // Se obtiene el elemento 'i' que tiene de fondo una flecha que indica que hay un submenú.
        let icon    = $(link).children("i.icon-right");
        // Se obtienen todos los 'li' del submenu obtenido
        let li      = submenu.children();
        // Creamos guardará el alto total a agregar para que se muestre el submenú.
        let Height  = 0;

        // Obtenemos el alto del submenú para saber si está oculto o está a la vista del usuario.
        let result = submenu.height();
        
        // Recorremos todos los 'li' del menú principal para remover todas las clases extras que existan.
        $("#main-menu > li").each(function (){
            // Obtenemos el submenú 'ul' de ese 'li' que se está recorriendo.
            let thisUl = $(this).children("ul");
            // Obtenemos el elemento 'a'.
            let thislink = $(this).children("a");
            // Y Obtenemos el elemento 'i' que tiene de fondo la flecha que indica que hay un submenú en el 'li'.
            let thisicon = $(thislink).children("i.icon-right");
            // Removemos la clase selección (Si la opción esta seleccionada).
            $(thislink).removeClass('select');
            // Remueve la clase rot90 que hace que el icono rote 90° grados hacia abajo indicando que el menú esta abierto.
            $(thisicon).removeClass('rot90');
            // Remueve los estilos del submenú, en este caso el height.
            $(thisUl).removeAttr('style');
        });
        
        // Se verifica si la variable result es igual a 0, es decir, siempre estuvo oculto el submenú.
        if(result == 0){
            // Se procede a agregar la clase selección para indicar cual 'li' fue el selecionado.
            $(link).addClass('select');
            // recorre todos los 'li' del ese submenú para obtener su alto y sumarlo para obtener el alto total.
            $(li).each(function (){
                Height += $(this).height()+1;
            });
            // Agregamos el alto correspondiente para que cada 'li' de este submenú se pueda visualizar.
            $(submenu).height(Height-1);
            // Agregamos la clase rot90 para que rote 90° grados hacia abajo indicando que el menu está abierto.
            $(icon).addClass('rot90');
        }
    });

    // mostrar todos los tooltips presentes en el documento.
    $('[data-toggle="tooltip"]').tooltip({"delay": { "show": 200, "hide": 100 }});

    // Desaparecer la imagen de carga una vez termine de cargar la página.
    setTimeout(function () { $(".loader").fadeOut("slow"); },200);

    $('#btn-show').click(showMenu);
    $('#menu-background').click(showMenu);
    function showMenu ()
    {
        if ($('#nav').hasClass('show-menu')) {
            $('#nav').removeClass('show-menu');
            $('#menu-background').removeAttr('style');
            $('body').removeAttr('style');
        } else {
            $('#menu-background').css('display','block');
            $('#menu-background').css('background','rgba(0,0,0,0.3)');
            $('body').css('overflow','hidden');
            $('#nav').addClass('show-menu');
        }
    }
});
