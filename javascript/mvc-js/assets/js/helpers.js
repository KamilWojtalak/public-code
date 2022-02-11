export const formDataToArray = (formData) => {
  return [...formData];
};

export const entiresToObject = (entries) => {
  return Object.fromEntries(entries);
};

export const formDataToObject = (formData) => {
  return entiresToObject(formDataToArray(formData))
};
