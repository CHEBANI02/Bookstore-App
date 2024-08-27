import React, { useState } from 'react';
import MultipleChoice from './MultipleChoice';
import Rating from './Rating';
import TextBox from './TextBox';
import TextInput from './TextInput';
import './Form.css';

const Form = () => {
  const [formData, setFormData] = useState({
    email: '',
    productName: '',
    question1: '',
    question2: '',
    question3: '',
    question4: '',
    question5: '',
    question6: null,
    question7: null,
    question8: null,
    question9: null,
    question10: null,
    question11: '',
  });

  const [showSuccess, setShowSuccess] = useState(false);

  const handleChange = (e) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value,
    });
    setShowSuccess(false); 
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    const errors = [];
    if (!formData.email) errors.push('Email Address');
    if (!formData.productName) errors.push('Product Name');
    if (!formData.question1) errors.push('Question 1');
    if (!formData.question2) errors.push('Question 2');
    if (!formData.question3) errors.push('Question 3');
    if (!formData.question4) errors.push('Question 4');
    if (!formData.question5) errors.push('Question 5');
    if (formData.question6 === '' || formData.question6 === null) errors.push('Question 6');
    if (formData.question7 === '' || formData.question7 === null) errors.push('Question 7');
    if (!formData.question11) errors.push('Question 11');

    if (errors.length > 0) {
      alert(`Please fill in the following mandatory fields: ${errors.join(', ')}`);
      return;
    }

    const sanitizedFormData = { ...formData };
    for (const key in sanitizedFormData) {
      if (sanitizedFormData[key] === null) {
        sanitizedFormData[key] = '';
      }
    }

    try {
      const response = await fetch('http://localhost/product_reviews/submit.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams(sanitizedFormData).toString(),
      });

      if (response.ok) {
        setFormData({
          email: '',
          productName: '',
          question1: '',
          question2: '',
          question3: '',
          question4: '',
          question5: '',
          question6: null,
          question7: null,
          question8: null,
          question9: null,
          question10: null,
          question11: '',
        });
        setShowSuccess(true); 
      } else {
        console.error('Submission error:', await response.text());
        setShowSuccess(false); 
      }
    } catch (error) {
      console.error('Submission error:', error);
      setShowSuccess(false); 
    }
  };

  return (
    <form onSubmit={handleSubmit}>
      <h1>Product Review Form</h1>

      
      {showSuccess && (
        <p style={{ color: 'green', marginBottom: '20px', textAlign: 'center' }}>
          Form submitted successfully!
        </p>
      )}

      
      <label htmlFor="email">
        Email Address <span className="required-asterisk">*</span>
      </label>
      <TextInput
        name="email"
        value={formData.email}
        onChange={handleChange}
        required
      />

      <label htmlFor="productName">
        Product Name <span className="required-asterisk">*</span>
      </label>
      <select
        name="productName"
        value={formData.productName}
        onChange={handleChange}
        required
      >
        <option value="">Select a Product</option>
        <option value="Product A">Product A</option>
        <option value="Product B">Product B</option>
        <option value="Product C">Product C</option>
        <option value="Product D">Product D</option>
      </select>

      <MultipleChoice
        name="question1"
        label="1. How would you rate the product quality?"
        options={['Excellent', 'Good', 'Average', 'Poor']}
        value={formData.question1}
        onChange={handleChange}
        required
      />
      <MultipleChoice
        name="question2"
        label="2. How satisfied are you with the customer service?"
        options={['Very Satisfied', 'Satisfied', 'Neutral', 'Dissatisfied']}
        value={formData.question2}
        onChange={handleChange}
        required
      />
      <MultipleChoice
        name="question3"
        label="3. Would you recommend this product to others?"
        options={['Definitely', 'Maybe', 'Not Sure', 'No']}
        value={formData.question3}
        onChange={handleChange}
        required
      />
      <MultipleChoice
        name="question4"
        label="4. How do you rate the value for money?"
        options={['Excellent', 'Good', 'Fair', 'Poor']}
        value={formData.question4}
        onChange={handleChange}
        required
      />
      <MultipleChoice
        name="question5"
        label="5. How likely are you to purchase this product again?"
        options={['Very Likely', 'Likely', 'Unlikely', 'Never']}
        value={formData.question5}
        onChange={handleChange}
        required
      />

      <Rating
        name="question6"
        label="6. Rate the product's ease of use (1-10)"
        value={formData.question6}
        onChange={handleChange}
        min={0}
        max={10}
        required
      />
      <Rating
        name="question7"
        label="7. Rate the product's durability (1-10)"
        value={formData.question7}
        onChange={handleChange}
        min={0}
        max={10}
        required
      />
      <Rating
        name="question8"
        label="8. Rate the product's design (1-10)"
        value={formData.question8}
        onChange={handleChange}
        min={0}
        max={10}
      />
      <Rating
        name="question9"
        label="9. Rate the product's performance (1-10)"
        value={formData.question9}
        onChange={handleChange}
        min={0}
        max={10}
      />
      <Rating
        name="question10"
        label="10. Rate the product's overall satisfaction (1-10)"
        value={formData.question10}
        onChange={handleChange}
        min={0}
        max={10}
      />

      <label htmlFor="question11">
        11. Additional Feedback <span className="required-asterisk">*</span>
      </label>
      <TextBox
        name="question11"
        value={formData.question11}
        onChange={handleChange}
        maxLength={2000}
        required
      />

      <button type="submit">Submit</button>

      <p style={{ color: 'red', marginTop: '20px' }}>
        * Asterisk marked fields are mandatory.
      </p>
    </form>
  );
};

export default Form;
