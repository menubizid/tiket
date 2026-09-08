// Configuration
const SPREADSHEET_ID = '1BWrsT1fXBH4KiaKISwkvHE_AYg3ikKEB9bv2H-ND0mo';

function doGet(e) {
  return HtmlService.createHtmlOutput('Backend Active Nation CMS Berjalan Normal. Silakan akses melalui antarmuka Blogger.');
}

function doPost(e) {
  let result = { success: true, message: 'Success' };
  try {
    const postData = JSON.parse(e.postData.contents);
    const action = postData.action;
    const payload = postData.payload || {};

    switch (action) {
        case 'INIT_DATA': result.data = initData(); break;
        case 'LOGIN': result.data = login(payload); break;
        case 'REGISTER': result.data = register(payload); break;
        case 'SAVE_PROFILE': result.data = saveProfile(payload); break;
        case 'SUBMIT_FORM_RESPONSE': submitFormResponse(payload); break;
        case 'SUBMIT_REVIEW': submitReview(payload); break;
        case 'DELETE_REVIEW': deleteReview(payload); break;
        case 'CREATE_ORDER': result.data = createOrder(payload); break;
        case 'SAVE_EVENT': saveEvent(payload); break;
        case 'DELETE_EVENT': deleteEvent(payload); break;
        case 'SAVE_CATEGORY': saveCategory(payload); break;
        case 'DELETE_CATEGORY': deleteCategory(payload); break;
        case 'SAVE_FORM_TEMPLATE': saveFormTemplate(payload); break;
        case 'DELETE_FORM_TEMPLATE': deleteFormTemplate(payload); break;
        case 'SAVE_SETTINGS': saveSettings(payload); break;
        case 'SAVE_PAYMENT': savePayment(payload); break;
        case 'DELETE_PAYMENT': deletePayment(payload); break;
        case 'RESOLVE_ORDER': resolveOrder(payload); break;
        case 'SCAN_TICKET': result.message = scanTicket(payload); break;
        case 'SAVE_INSTRUCTOR': saveInstructor(payload); break;
        case 'DELETE_INSTRUCTOR': deleteInstructor(payload); break;
        case 'SAVE_VOUCHER': saveVoucher(payload); break;
        case 'DELETE_VOUCHER': deleteVoucher(payload); break;
        default: throw new Error('Unknown action: ' + action);
    }
  } catch (err) {
    result = { success: false, message: err.message || String(err) };
  }

  return ContentService.createTextOutput(JSON.stringify(result))
    .setMimeType(ContentService.MimeType.JSON);
}

// ---------------------------------------------------------
// Helper functions
// ---------------------------------------------------------

function getSheet(sheetName) {
  const ss = SpreadsheetApp.openById(SPREADSHEET_ID);
  let sheet = ss.getSheetByName(sheetName);
  if (!sheet) {
    sheet = ss.insertSheet(sheetName);
  }
  return sheet;
}

function getSheetData(sheetName) {
  const sheet = getSheet(sheetName);
  const data = sheet.getDataRange().getValues();
  if (data.length <= 1) return [];
  const headers = data[0];
  const rows = [];
  for (let i = 1; i < data.length; i++) {
    const row = {};
    for (let j = 0; j < headers.length; j++) {
      row[headers[j]] = data[i][j];
    }
    rows.push(row);
  }
  return rows;
}

function appendRowToSheet(sheetName, rowData, headers) {
  const sheet = getSheet(sheetName);
  const existingData = sheet.getDataRange().getValues();
  if (existingData.length === 0 || (existingData.length === 1 && existingData[0][0] === "")) {
      sheet.appendRow(headers);
  }

  const currentHeaders = sheet.getDataRange().getValues()[0];
  const rowToAppend = currentHeaders.map(h => rowData[h] !== undefined ? rowData[h] : '');
  sheet.appendRow(rowToAppend);
}

function updateRowInSheet(sheetName, idField, idValue, newData) {
  const sheet = getSheet(sheetName);
  const data = sheet.getDataRange().getValues();
  if (data.length <= 1) return false;
  const headers = data[0];
  const idIndex = headers.indexOf(idField);
  if (idIndex === -1) return false;

  for (let i = 1; i < data.length; i++) {
    if (String(data[i][idIndex]) === String(idValue)) {
      for (const key in newData) {
        const colIndex = headers.indexOf(key);
        if (colIndex !== -1) {
          sheet.getRange(i + 1, colIndex + 1).setValue(newData[key]);
        }
      }
      return true;
    }
  }
  return false;
}

function deleteRowInSheet(sheetName, idField, idValue) {
  const sheet = getSheet(sheetName);
  const data = sheet.getDataRange().getValues();
  if (data.length <= 1) return false;
  const headers = data[0];
  const idIndex = headers.indexOf(idField);
  if (idIndex === -1) return false;

  for (let i = 1; i < data.length; i++) {
    if (String(data[i][idIndex]) === String(idValue)) {
      sheet.deleteRow(i + 1);
      return true;
    }
  }
  return false;
}

function generateId(prefix) {
  return prefix + '-' + Math.floor(Math.random() * 900000 + 100000);
}

// ---------------------------------------------------------
// Action Handlers
// ---------------------------------------------------------

function initData() {
  const db = {
    events: getSheetData('Events'),
    orders: getSheetData('Orders'),
    users: getSheetData('Users'),
    payments: getSheetData('Payments'),
    checkins: getSheetData('Checkins'),
    cities: getSheetData('Cities'),
    categories: getSheetData('Categories'),
    instructors: getSheetData('Instructors'),
    vouchers: getSheetData('Vouchers'),
    formTemplates: getSheetData('FormTemplates'),
    settings: getSheetData('Settings')
  };
  return db;
}

function login(payload) {
  const { phone, pass } = payload;

  if (phone === 'admin' && pass === 'demo') {
    return { Phone: 'admin', Role: 'admin', Name: 'Super Admin' };
  }

  let instructors = getSheetData('Instructors');
  for (let i = 0; i < instructors.length; i++) {
    if (String(instructors[i].Phone) === String(phone) && String(instructors[i].Pass) === String(pass)) {
      return instructors[i];
    }
  }

  let users = getSheetData('Users');
  for (let i = 0; i < users.length; i++) {
    if (String(users[i].Phone) === String(phone) && String(users[i].Pass) === String(pass)) {
      return users[i];
    }
  }

  throw new Error('ID/No.HP atau Kata Sandi salah');
}

function register(payload) {
  const { name, phone, city, pass } = payload;
  let users = getSheetData('Users');
  for (let i = 0; i < users.length; i++) {
    if (String(users[i].Phone) === String(phone)) {
      throw new Error('Nomor HP sudah terdaftar');
    }
  }

  const newUser = { Phone: phone, Name: name, Pass: pass, City: city, Role: 'customer', Avatar: '' };
  const headers = ['Phone', 'Name', 'Pass', 'City', 'Role', 'Avatar'];
  appendRowToSheet('Users', newUser, headers);
  return newUser;
}

function saveProfile(payload) {
  const { phone, name, avatar } = payload;

  if (phone === 'admin') {
      return { Phone: 'admin', Role: 'admin', Name: name };
  }

  // Try Instructor first
  let instructors = getSheetData('Instructors');
  let isInstructor = false;
  for(let i=0; i<instructors.length; i++) {
      if(String(instructors[i].Phone) === String(phone)) {
          updateRowInSheet('Instructors', 'Phone', phone, { Name: name, Avatar: avatar });
          isInstructor = true;
          return getSheetData('Instructors').find(x => String(x.Phone) === String(phone));
      }
  }

  if (!isInstructor) {
      updateRowInSheet('Users', 'Phone', phone, { Name: name, Avatar: avatar });
      return getSheetData('Users').find(x => String(x.Phone) === String(phone));
  }
}

function submitFormResponse(payload) {
  const { ticketId, eventId, customerPhone, data } = payload;

  const responseData = {
    TicketId: ticketId,
    EventId: eventId,
    CustomerPhone: customerPhone,
    DataJSON: JSON.stringify(data),
    Timestamp: new Date().toISOString()
  };

  appendRowToSheet('FormResponses', responseData, ['TicketId', 'EventId', 'CustomerPhone', 'DataJSON', 'Timestamp']);

  updateRowInSheet('Orders', 'ID', ticketId, { FormFilled: 'true' });
}

function submitReview(payload) {
  const { eventId, customerPhone, customerName, rating, comment } = payload;

  const reviewData = {
    ID: generateId('REV'),
    EventId: eventId,
    CustomerPhone: customerPhone,
    CustomerName: customerName,
    Rating: rating,
    Comment: comment,
    Timestamp: new Date().toISOString()
  };

  const reviews = getSheetData('Reviews');
  const existing = reviews.find(r => r.EventId === eventId && r.CustomerPhone === customerPhone);

  if (existing) {
      updateRowInSheet('Reviews', 'ID', existing.ID, reviewData);
  } else {
      appendRowToSheet('Reviews', reviewData, ['ID', 'EventId', 'CustomerPhone', 'CustomerName', 'Rating', 'Comment', 'Timestamp']);
  }
}

function deleteReview(payload) {
    const { eventId, customerPhone } = payload;
    const reviews = getSheetData('Reviews');
    const existing = reviews.find(r => r.EventId === eventId && r.CustomerPhone === customerPhone);
    if(existing) {
        deleteRowInSheet('Reviews', 'ID', existing.ID);
    }
}

function createOrder(payload) {
    const { eventId, customerPhone, finalPrice, qty, paymentId } = payload;
    const orderId = generateId('ORD');
    const newOrder = {
        ID: orderId,
        EventId: eventId,
        CustomerPhone: customerPhone,
        Price: finalPrice,
        Qty: qty,
        PaymentId: paymentId,
        Status: 'pending',
        FormFilled: 'false',
        CheckinCount: 0,
        Timestamp: new Date().toISOString()
    };
    appendRowToSheet('Orders', newOrder, ['ID', 'EventId', 'CustomerPhone', 'Price', 'Qty', 'PaymentId', 'Status', 'FormFilled', 'CheckinCount', 'Timestamp']);
    return { orderId: orderId };
}

function saveEvent(payload) {
    const isNew = !payload.id;
    const id = payload.id || generateId('EV');

    // Slugify title if new
    let slug = payload.title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');

    const eventData = {
        ID: id,
        Title: payload.title,
        Slug: slug,
        Banner: payload.banner,
        Desc: payload.desc,
        Category: payload.category,
        City: payload.city,
        Date: payload.date,
        Price: payload.price,
        Instructor: payload.instructor,
        Capacity: payload.capacity,
        Venue: payload.venue,
        Address: payload.address,
        Gmaps: payload.gmaps,
        Visibility: payload.visibility
    };

    if (isNew) {
        appendRowToSheet('Events', eventData, ['ID', 'Title', 'Slug', 'Banner', 'Desc', 'Category', 'City', 'Date', 'Price', 'Instructor', 'Capacity', 'Venue', 'Address', 'Gmaps', 'Visibility']);
    } else {
        updateRowInSheet('Events', 'ID', id, eventData);
    }
}

function deleteEvent(payload) {
    deleteRowInSheet('Events', 'ID', payload.id);
}

function saveCategory(payload) {
    const isNew = !payload.id;
    const id = payload.id || generateId('CAT');
    const data = { ID: id, Name: payload.name, FormTemplateId: payload.formTemplateId || '' };
    if (isNew) {
        appendRowToSheet('Categories', data, ['ID', 'Name', 'FormTemplateId']);
    } else {
        updateRowInSheet('Categories', 'ID', id, data);
    }
}

function deleteCategory(payload) {
    deleteRowInSheet('Categories', 'ID', payload.id);
}

function saveFormTemplate(payload) {
    const isNew = !payload.id;
    const id = payload.id || generateId('FT');
    const data = { ID: id, Title: payload.title, FieldsJSON: JSON.stringify(payload.fields) };
    if (isNew) {
        appendRowToSheet('FormTemplates', data, ['ID', 'Title', 'FieldsJSON']);
    } else {
        updateRowInSheet('FormTemplates', 'ID', id, data);
    }
}

function deleteFormTemplate(payload) {
    deleteRowInSheet('FormTemplates', 'ID', payload.id);
}

function saveSettings(payload) {
    const data = { ID: 'SYS-1', WaReminder: payload.waReminder, WaThankYou: payload.waThankYou };
    if(!updateRowInSheet('Settings', 'ID', 'SYS-1', data)){
        appendRowToSheet('Settings', data, ['ID', 'WaReminder', 'WaThankYou']);
    }
}

function savePayment(payload) {
    const isNew = !payload.id;
    const id = payload.id || generateId('PAY');
    const data = { ID: id, Type: payload.type, Name: payload.name, AccountNo: payload.accountNo, AccountName: payload.accountName, QrUrl: payload.qrUrl, IsActive: payload.isActive ? 'true' : 'false' };
    if (isNew) {
        appendRowToSheet('Payments', data, ['ID', 'Type', 'Name', 'AccountNo', 'AccountName', 'QrUrl', 'IsActive']);
    } else {
        updateRowInSheet('Payments', 'ID', id, data);
    }
}

function deletePayment(payload) {
    deleteRowInSheet('Payments', 'ID', payload.id);
}

function resolveOrder(payload) {
    const { orderId, isApproved } = payload;
    const status = isApproved ? 'approved' : 'rejected';
    updateRowInSheet('Orders', 'ID', orderId, { Status: status });
}

function scanTicket(payload) {
    const { ticketId } = payload;
    const orders = getSheetData('Orders');
    const order = orders.find(o => o.ID === ticketId);
    if (!order) throw new Error('Tiket tidak ditemukan');
    if (order.Status !== 'approved') throw new Error('Tiket belum disetujui');

    // Check form
    const events = getSheetData('Events');
    const event = events.find(e => e.ID === order.EventId);
    const categories = getSheetData('Categories');
    const cat = categories.find(c => c.Name === event?.Category);
    if (cat && cat.FormTemplateId && order.FormFilled !== 'true') {
        throw new Error('Peserta belum mengisi form wajib');
    }

    const count = parseInt(order.CheckinCount || '0');
    if (count >= parseInt(order.Qty)) {
        throw new Error('Tiket sudah digunakan seluruhnya');
    }

    updateRowInSheet('Orders', 'ID', ticketId, { CheckinCount: count + 1 });

    const checkinData = { ID: generateId('CHK'), TicketId: ticketId, Timestamp: new Date().toISOString() };
    appendRowToSheet('Checkins', checkinData, ['ID', 'TicketId', 'Timestamp']);

    return 'Check-in berhasil. Sisa: ' + (parseInt(order.Qty) - (count + 1));
}

function saveInstructor(payload) {
    const { oldPhone, name, phone, pass } = payload;
    const data = { Phone: phone, Name: name, Pass: pass, Role: 'instructor' };

    if (oldPhone) {
        updateRowInSheet('Instructors', 'Phone', oldPhone, data);
    } else {
        appendRowToSheet('Instructors', data, ['Phone', 'Name', 'Pass', 'Role', 'City', 'Avatar']);
    }
}

function deleteInstructor(payload) {
    deleteRowInSheet('Instructors', 'Phone', payload.phone);
}

function saveVoucher(payload) {
    const isNew = !payload.id;
    const id = payload.id || generateId('V');
    const data = { ID: id, Code: payload.code, Type: payload.type, Val: payload.val };
    if (isNew) {
        appendRowToSheet('Vouchers', data, ['ID', 'Code', 'Type', 'Val']);
    } else {
        updateRowInSheet('Vouchers', 'ID', id, data);
    }
}

function deleteVoucher(payload) {
    deleteRowInSheet('Vouchers', 'ID', payload.id);
}
