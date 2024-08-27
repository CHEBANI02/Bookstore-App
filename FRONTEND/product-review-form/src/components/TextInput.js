import React from 'react';

const TextInput = ({ name, label, value, onChange, required }) => (
  <div>
    <label>{label}</label>
    <input
      type="text"
      name={name}
      value={value}
      onChange={onChange}
      required={required}
    />
  </div>
);

export default TextInput;
