import React from 'react';

const TextBox = ({ name, label, value, onChange, maxLength }) => (
  <div>
    <label>{label}</label>
    <textarea
      name={name}
      value={value}
      onChange={onChange}
      maxLength={maxLength}
    />
  </div>
);

export default TextBox;
