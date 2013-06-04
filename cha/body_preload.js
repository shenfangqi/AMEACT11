function ImagePreloader(ld_images,rd_images,lu_images,ru_images, pObj) {
    // store the call-back
    this.pObj = pObj;

    // initialize internal state.
    this.nLoaded = 0;
    this.nProcessed = 0;
    this.aImages = [];

    // record the number of images.
    this.nImages = ld_images.length+rd_images.length+lu_images.length+ru_images.length;

    // for each image, call preload()
    for ( var i = 0; i < ld_images.length; i++ )
        this.preload(ld_images[i],"ld");
    for ( var i = 0; i < rd_images.length; i++ )
        this.preload(rd_images[i],"rd");
    for ( var i = 0; i < lu_images.length; i++ )
        this.preload(lu_images[i],"lu");
    for ( var i = 0; i < ru_images.length; i++ )
        this.preload(ru_images[i],"ru");
}


ImagePreloader.prototype.preload = function(image,orient) {
    // create new Image object and add to array
    var oImage = new Image;

    var fn = image.split("/");
    fn = fn[fn.length-1];
    fn = fn.split(".")[0];
    this.aImages[orient+"_"+fn]=oImage;
//alert(image +":"+ orient+"_"+fn);
    // set up event handlers for the Image object
    oImage.onload = ImagePreloader.prototype.onload;
    oImage.onerror = ImagePreloader.prototype.onerror;
    oImage.onabort = ImagePreloader.prototype.onabort;

    // assign pointer back to this.
    oImage.oImagePreloader = this;
    oImage.bLoaded = false;

    // assign the .src property of the Image object
    oImage.src = image;
}


ImagePreloader.prototype.onComplete = function() {
    this.nProcessed++;
    if ( this.nProcessed == this.nImages )  {
        //alert("loaded");
        //this.pObj.drawFrame();
        this.pObj.startUP();
    }
}


ImagePreloader.prototype.onload = function() {
    this.bLoaded = true;
    this.oImagePreloader.nLoaded++;
    this.oImagePreloader.onComplete();
}


ImagePreloader.prototype.onerror = function() {
    this.bError = true;
    this.oImagePreloader.onComplete();
}


ImagePreloader.prototype.onabort = function() {
    this.bAbort = true;
    this.oImagePreloader.onComplete();
}


ImagePreloader.prototype.getBodyImg = function(fn) {
    return this.aImages[fn];
}


//var img_arr = ["images/lLeg.png","images/shoes.png","images/lHand.png","images/body.png","images/rLeg.png","images/shoes.png","images/rHand.png","images/head.png"];
//var ss = new ImagePreloader(img_arr,ss1);