
Object.prototype.each = function(f) {
  for(var prop in this) {
    if (Object.prototype.hasOwnProperty(prop)) {
      continue; 
    }

    var value = this[prop]
    f.call(value, prop, value) 
  }
};

Object.prototype.isDomElement = function() {

  return ((this.tagName||false)||this===window||this===document);
};

Object.prototype.hasAttribute = function(attr) {

  if(!this.getAttribute) return false;

  if(!this.getAttribute(attr).length) return false;

  return true;
};

Object.prototype.on = function(event, func) {

  if(!this.isDomElement()){
    return false;
  }

  return this.addEventListener(event, func, true);
  
};

Object.prototype.parents = function(selector) {

  if(!this.isDomElement() || !selector){
    return false;
  }

  var parent = this.parentNode;

  do {

    if(parent.matches(selector)){
      return parent;
    }

  } while(parent = parent.parentNode)

  return false;

};

Object.prototype.serializeObject = function(event, data) {

  returnArray = {};
  for (var i = 0; i < this.length; i++){
    returnArray[this[i]['name']] = this[i]['value'];
  }
  return returnArray;

};

Object.prototype.trigger = function(event, data) {

  if(!this.isDomElement()){
    return false;
  }

  return this.dispatchEvent(new CustomEvent(event, {detail:data}));

};





