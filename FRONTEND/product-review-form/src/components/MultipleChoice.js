import React from 'react';
import './Form.css';  

const MultipleChoice = ({ name, label, options, value, onChange, required }) => {
  return (
    <div className="multiple-choice">
      <label htmlFor={name}>
        {label} {required && <span className="required-asterisk">*</span>}
      </label>
      <div>
        {options.map(option => (
          <div key={option}>
            <input
              type="radio"
              id={`${name}-${option}`}
              name={name}
              value={option}
              checked={value === option}
              onChange={onChange}
              required={required}
            />
            <label htmlFor={`${name}-${option}`}>{option}</label>
          </div>
        ))}
      </div>
    </div>
  );
};

export default MultipleChoice;
