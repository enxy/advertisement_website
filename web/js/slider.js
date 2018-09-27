function Slider(){
    this.slides = document.querySelectorAll('.slider-main-elems');
    this.index = 0;
    this.slides_num = this.slides.length;

    this.next_slide = function(){
        this.slides[this.index].classList.remove('active');
        (this.index === 2) ? this.index=0 : this.index++;
        this.slides[this.index].classList.add('active');
    };
    this.remove_slide = function(){
        this.slides[this.index].classList.remove('active');
    };
    setInterval(function(){this.next_slide()}.bind(this), 5000);
}
const slider = new Slider();
