/**
 * @name jquery.particulator.js
 * @author Romain Lienard <me@rlienard.fr>
 * @http: http://rlienard.fr
 * @copyright (c)2012 rlienard (Romain Lienard)
 * @version 0.0.1
 * @package ***
 * @date: 03/04/13
 * @time: 06:30
 *
 *	Permission is hereby granted, free of charge, to any person obtaining a copy of this
 *	software and associated documentation files (the "Software"), to deal in the Software
 *	without restriction, including without limitation the rights to use, copy, modify, merge,
 *	publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons
 *	to whom the Software is furnished to do so, subject to the following conditions:
 *
 * 	The above copyright notice and this permission notice shall be included in all copies
 *	or substantial portions of the Software.
 *
 *	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING
 *	BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 *	NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
 *	DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * 	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 **/

!function ($) {
    'use strict';

////////////////////////////////////

    var handler;

    /***
     * MODULE HANDLER --------------------------------------------------------------------------------------------------
     */

    function getTime(){
        var d = new Date();
        return d.getTime();
    }

    function random(min,max){
        if(min == max)return min;
        return (Math.random() * ((max + 1) - min)) + min;
    }

    /**
     * @name Class Event
     *
     * @param name
     * @param doEvent
     * @constructor
     */
    function _Event(name,doEvent){
        this.id = null;
        this.name = name;
        this.event = doEvent;
    }

    /**
     * @name Core.handler.clock
     *
     * @description Clock object implements a loop with a setTimeOut() and "interval" passed as a parameter
     this loop indefinitely repeat an action that time is the Clock does not pause.
     generally the Clock will be managed by Core Handler
     *
     * /// methods
     * Clock::start()
     * Clock::restart()
     * Clock::stop()
     * Clock::setAction(action {Function})
     *
     * @param interval
     * @return {constructor}
     * @constructor
     */
    function Clock(interval){
        this.i = interval;
        this.t = null;
        this.a = null;
        this.debutfps = 0;
        this.finfps = 0;
        this.fps = 0;
    }

    Clock.prototype = {
        constructor: Clock,
        /* Start the Clock */
        start : function(){
            this.debutfps = getTime();
            this.t = setTimeout(function(){handler.clock.restart();},this.i);
        },

        /* Restart the Clock if clock pause */
        restart : function(){
            if(typeof this.a == "function")
                this.a();

            this.finfps = getTime();
            this.fps = Math.round(1000/(this.finfps - this.debutfps));

            if( (this.finfps - this.debutfps) >= this.i ){
                return this.start();
            }else{
                return this.t = setTimeout(this.start, this.i-(this.finfps - this.debutfps));
            }
        },

        /* Stop the clock */
        stop : function(){
            clearTimeout(this.t);
        },

        /* Set an repeated action at the end of all loop */
        setAction : function(action){
            this.a = action;
        }

    };

    /**
     * @name Core.handler.buffer
     *
     * @constructor
     */
    function Buffer(){
        this.b = [];
        this.index = 1;

        this.length = 0;
    }

    Buffer.prototype = {
        constructor: Buffer,
        Add : function(e){
            if(this.getIdOfList(e.name)){
                return false;
            }
            if( e.constructor == _Event ){
                e.id = this.index;
                this.b[this.b.length] = e;
                this.length = this.b.length;
                return this.index++;
            }
            return false;
        },

        remove : function(str){
            var e = this.getIdOfList(str);
            if( e.constructor == Number){
                for(var i = e; i < ( this.b.length - 1); i++ ){
                    this.b[i]=this.b[i+1];
                }
                this.b.pop();
                this.index--;
            }
            this.length = this.b.length;
        },

        getIdOfList : function(id){
            var e = false,i= 0,l=0;
            switch(typeof(id)){
                case "number":
                    for(i=0,l=this.b.length; i < l ;i++){
                        if( id == this.b[i].id ){
                            e = i;
                            return e;
                        }
                    }
                    return false;
                    break;
                case "string":
                    for(i=0,l=this.b.length; i < l ;i++){
                        if( id == this.b[i].name ){
                            e = i;
                            return e;
                        }
                    }
                    return false;
                    break;
            }
            return false;
        },

        execBuffer : function(){
            $.each(this.b,function(key,obj){
                obj.event();
            });
            return true;
        },

        getList : function(){
            return this.b;
        },

        setList : function(array){
            if(typeof(array) == "array")
                this.b = array;
            else this.b = [];
        }
    };

    /**
     * @name Core.hanlder
     *
     * @constructor
     */
    function Handler(){
        var that = this,
            interval = 1000/40;

        this.clock = new Clock(interval);
        this.buffer = new Buffer();

        this.clock.setAction(function(){
            that.buffer.execBuffer();
        });

        this.activated = false;
    }

    Handler.prototype = {
        constructor: Handler,
        getInterval : function(){ return interval; },

        addEvent : function(name,action){
            this.buffer.Add(new _Event(name,action));
        },

        removeEvent : function(str){
            this.buffer.remove(str);
        },

        unset : function(){
            this.buffer.setList([]);
        },

        pause : function(){
            if(this.activated){
                this.activated = false;
                this.clock.stop();
            }
        },

        play : function(){
            if(!this.activated){
                this.activated = true;
                this.clock.start();
            }
        }
    };

    handler = new Handler();
    /***
     *  END MODULE HANDLER ---------------------------------------------------------------------------------------------
     */

    function Particle($elem,parent){
        this.isActive = false;
        this.isVisible = false;

        this.$element = $elem;
        this.parent = parent;
        $elem[0].attachedObject = this;

    }

    Particle.prototype = {
        constructor: Particle,
        init: function(){

            var o = this.parent.options;

            this.x = random(o.minOriginX, o.maxOriginX);
            this.y = random(o.minOriginY, o.maxOriginY);
            this.originX = this.x;
            this.originY = this.y;
            this.speed = random(o.minSpeed, o.maxSpeed);
            this.angle = Math.PI * random(o.minAngle, o.maxAngle) / 180 ;
            this.acceleration = o.acceleration; //TODO
            this.size = random(o.minSize, o.maxSize); //TODO
            this.endLife = random(o.minLife, o.maxLife);

            this.life = getTime();

            this.isActive = true;

            this.step();
            this.parent.$canvas.append(this.$element);
            this.isVisible = true;
        },
        reset: function(){
            var o = this.parent.options;

            this.x = random(o.minOriginX, o.maxOriginX);
            this.y = random(o.minOriginY, o.maxOriginY);
            this.originX = this.x;
            this.originY = this.y;
            this.speed = random(o.minSpeed, o.maxSpeed);
            this.angle = Math.PI * random(o.minAngle, o.maxAngle) / 180 ;
            this.acceleration = o.acceleration; //TODO
            this.size = random(o.minSize, o.maxSize); //TODO
            this.endLife = random(o.minLife, o.maxLife);

            this.life = getTime();
            this.step();
            this.$element.show();
            this.isVisible = true;
        },
        step: function(){
            var t = this.getTimeRat(),
                d = this.speed * t,
                o = this.parent.options;

            if(this.endLife < t){
                this.$element.hide();
                this.isVisible = false;
            }

            this.x = d * Math.cos(this.angle);
            this.y = d * Math.sin(this.angle);

            this.$element.css({top: this.y + this.originY, left:this.x + this.originX});
            o.OnStep(this.$element, this.size, 1 - (t/this.endLife));

        },
        getTimeRat: function(){
            if(this.parent.handler.clock.fps == 0)return 0;
            return ( getTime() - this.life )/1000;
        }
    };


    /* PARTICULATOR
     * ************* */

    function Particulator(element, options) {
        this.$canvas = $(element);
        this.options = $.extend({}, $.fn.particulator.defaults, options);
        this.handler = handler;
        this.name = getTime();
        this.particles = [];

        this.start();
    }

    Particulator.prototype = {
        start: function() {
            var that = this,
                $canvas = this.$canvas;

            for(var i=0;i<this.options.numberParticles;i++){
                this.addParticle();
            }

            this.handler.play();
            this.handler.addEvent("event_particle_gen"+this.name,function(){
                $.each(that.particles,function(key,particle){
                    if(particle.isActive && particle.isVisible){
                        particle.step();
                        return;
                    }
                    if(particle.isActive && !particle.isVisible){
                        particle.reset();
                        return;
                    }
                    if(!particle.isActive){
                        particle.init();
                    }
                });
            });
        },

        stop : function(context) {
            this.handler.removeEvent("event_particle_gen"+this.name);
        },
        stopHandler : function() {
            this.handler.stop();
        },

        newParticle : function() {
            var obj = new Particle((this.options.model).clone(),this);
            obj.$element.addClass('particle_'+this.name);
            return obj;
        },
        addParticle : function() {
            this.particles.push(this.newParticle());
        },

        defaults : {
            mode: 'from-origin',
            contact:0,
            gravity:0,
            acceleration: 1,
            minSpeed: 5,
            maxSpeed: 10,
            minOriginX: 0,
            maxOriginX: 5,
            minOriginY: 0,
            maxOriginY: 5,
            minAngle: 0,
            maxAngle: 0,
            minLife: 5,
            maxLife: 10,
            minSize: 5,
            maxSize: 64,
            minDateOfBirth: 0,
            maxDateOfBirth: 100,
            numberParticules: 1,
            model: $('<div></div>',{
                'class':'particulator_default',
                width: 62,
                height: 62
            }),
            OnStep: function(particule,size,life){}
        }
    };
    /* PLUGIN DEFINITION
     * ======================== */

    $.fn.particulator = function (option, context) {
        return this.each(function () {
            var $this = $(this)
                , data = $this.data('particulator')
                , options = typeof option == 'object' && option;

            if (!data)
                $this.data('particulator', (data = new Particulator(this, options)));
            if (option == 'start')
                data.start(context);
        })
    };

    $.fn.particulator.Constructor = Particulator;

}(window.jQuery);