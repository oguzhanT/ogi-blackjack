$.fn.timer = function(time, callback){
    if ( $.isArray(time) ){
        this.minute = time[0];
        this.second = time[1];
    } else {
        this.minute = time - 1;
        this.second = 60;
    }
    var self = this,
        timer = function(){
            if ( self.minute == '00' && self.second == '00' ){
                clearInterval(self.interval);
                self.interval = null;
                callback();
            } else {
                if ( self.second > 0 ) self.second--;
                else {
                    self.minute -= 1;
                    self.second = 59;
                }
                $(self).text((self.minute < 10 ? '0' + self.minute : self.second) + ':' + (self.second < 10 ? '0' + self.second : self.second));
            }
        };
    timer();
    this.interval = setInterval(timer, 1000);
}
