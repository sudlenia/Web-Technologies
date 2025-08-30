$.ajax({
  url: "data.json",
  method: "GET",
  dataType: "json",
  success: function (json) {
    const gallery = json.images;

    let div = null;
    const $images = $(".images");
    $.each(gallery, function (index, image) {
      if (index % 2 === 0) {
        $images.append($("<h3>").text(`Group ${index / 2}`));
        div = $("<div>").addClass("image-group");
        $images.append(div);
      }

      div.append(
        $("<img>", {
          id: index,
          src: image.file,
          alt: image.name,
          class: "image-item",
        })
      );
    });

    $images.accordion();
    $("#tabs").tabs();
    $("#datepicker").datepicker();
    $("#progressbar").progressbar({
      value: 0,
    });

    const $body = $("body");
    const $allImages = $(".image-item");

    let index = 0;
    const $btnNext = $(".btn-next");
    const $btnPrev = $(".btn-prev");
    const $btnSlider = $(".btn-slider");

    let slider = null;
    let isPlaying = false;
    const duration = 4000;
    let progressValue = 0;

    $allImages.on("click", function () {
      const img = $(this);
      $body.find(".image-click").remove();
      const zoom = img.clone();
      setImageZoom(zoom);
      index = img.attr("id");
    });

    function setBorderToggle(zoom) {
      zoom.on("click", function () {
        $(this).toggleClass("image-pick");
      });
    }

    function setImageZoom(zoom) {
      zoom.appendTo($body);
      zoom.addClass("image-click");
      setBorderToggle(zoom);
    }

    function updateIndex(currentIndex) {
      currentIndex = (currentIndex + $allImages.length) % $allImages.length;
      showImage(currentIndex);
    }

    function showImage(index) {
      const $currentImage = $body.find(".image-click");
      const $newImage = $allImages.eq(index).clone();

      $currentImage.fadeOut(200, "linear", function () {
        $(this).remove();
        setImageZoom($newImage);
        $newImage.fadeOut(0, "linear");
        $newImage.fadeIn(300, "linear");
      });
    }

    function reserProgressBar() {
      progressValue = 0;
      $("#progressbar").progressbar("value", progressValue);
    }

    function updateProgressBar() {
      const step = 100 / (duration / 100);
      progressValue += step;
      if (progressValue > 100) {
        progressValue = 100;
      }
      $("#progressbar").progressbar("value", progressValue);
    }

    function incrementIndex(isIncrement) {
      index = isIncrement ? index + 1 : index - 1;
      updateIndex(index);
    }

    $btnNext.on("click", function () {
      incrementIndex(true);
    });

    $btnPrev.on("click", function () {
      incrementIndex(false);
    });

    $btnSlider.on("click", function () {
      if (isPlaying) {
        clearInterval(slider);
        slider = null;
        isPlaying = false;
        reserProgressBar();
        $(this).text("Запустить слайдер");
      } else {
        slider = setInterval(function () {
          progressValue = 0;
          incrementIndex(true);
        }, duration);

        const progressInterval = setInterval(function () {
          if (!isPlaying) {
            clearInterval(progressInterval);
            return;
          }
          updateProgressBar();
        }, 100);

        isPlaying = true;
        $(this).text("Остановить слайдер");
      }
    });
  },
});
