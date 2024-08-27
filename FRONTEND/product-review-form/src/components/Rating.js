import React from 'react';

const Rating = ({ name, label, value, onChange, min, max, required }) => {
  return (
    <div className="rating">
      <label htmlFor={name}>
        {label} {required && <span className="required-asterisk">*</span>}
      </label>
      <input
        type="number"
        id={name}
        name={name}
        value={value}
        onChange={onChange}
        min={min}
        max={max}
        required={required}
      />
    </div>
  );
};

export default Rating;
