# ACF Fields Guide - Fotobudka WordPress Theme

## 🎯 **ROZWIĄZANE PROBLEMY**

Ten theme został zaktualizowany, aby wszystkie poprzednio **hardcoded wartości** były teraz **edytowalne przez WordPress Admin** za pomocą pól ACF.

## ✅ **NOWE EDYTOWALNE POLA**

### **1. NAGŁÓWKI I TYTUŁY SEKCJI**
- **Tytuł główny** - "Witamy w Fotobudka Chojnice!"
- **Podtytuł główny** - "Dopełniamy, by na Twoim wydarzeniu nie zabrakło Atrakcji!"
- **Tytuł sekcji oferty** - "Nasza oferta" (z HTML dla kolorowania)
- **Tytuł sekcji statystyk** - "My w liczbach" (z HTML)
- **Tytuł sekcji galerii** - "Nasza galeria" (z HTML)

### **2. STATYSTYKI "MY W LICZBACH"**
- **Statystyka 1**: Liczba (np. "100+") + Opis (np. "zadowolonych klientów")
- **Statystyka 2**: Liczba (np. "5 lat") + Opis (np. "na rynku") 
- **Statystyka 3**: Liczba (np. "∞") + Opis (np. "uśmiechów")

### **3. TYTUŁY KART OFERT**
- **Fotobudka 360** - edytowalny tytuł
- **Fotolustro** - edytowalny tytuł
- **Ciężki dym** - edytowalny tytuł
- **Fontanny iskier** - edytowalny tytuł
- **Neonowe napisy** - edytowalny tytuł

### **4. OPISY KART OFERT**
- Wszystkie 5 opisów usług są edytowalne (zachowane z poprzedniej wersji)

### **5. KONTAKT I MEDIA SPOŁECZNOŚCIOWE**
- **Tytuł sekcji kontakt** - "Dotrzyj do nas za pomocą"
- **Numer telefonu** - wyświetlany w stopce
- **Link Facebook** + **Nazwa profilu** (np. "@OG Eventspot")
- **Link Instagram** + **Nazwa profilu** (np. "@og.eventspot")

## 🎨 **JAK EDYTOWAĆ**

### **Dla Strony Głównej:**
1. Przejdź do **Pages → Edit** strony głównej
2. Znajdź sekcję **"Edycja treści strony głównej"**
3. Pola są podzielone na zakładki:
   - **NAGŁÓWKI I TYTUŁY SEKCJI**
   - **STATYSTYKI "MY W LICZBACH"**  
   - **TYTUŁY KART OFERT**
   - **OPISY KART OFERT**
   - **KONTAKT I MEDIA SPOŁECZNOŚCIOWE**

### **Dla Stron Miast:**
1. Edytuj stronę z szablonem "Strona Miasta"
2. Znajdź sekcję **"Edycja treści dla miasta"**
3. Wszystkie pola są dziedziczone z strony głównej + dodatkowe pola specyficzne dla miasta

## 🔧 **FUNKCJE TECHNICZNE**

### **Backward Compatibility**
- Wszystkie pola mają **wartości domyślne** identyczne z poprzednimi hardcoded wartościami
- Jeśli pole jest puste, używana jest wartość domyślna
- **Brak ryzyka** wystąpienia pustych miejsc na stronie

### **HTML Support**
- Pola tytułów wspierają HTML (np. `<span style="color: #801039">tekst</span>`)
- Umożliwia kolorowanie części tekstu

### **Dynamic Gallery**
- `page-miasto.php` teraz używa **dynamicznej galerii** jak `index.php`
- Zarządzanie obrazami przez WordPress Admin (istniejące funkcje)

## 🎯 **REZULTAT**

**100% edytowalny theme** przez WordPress Admin - **ZERO hardcoded content!**

### **Edytowalne poprzez ACF:**
✅ Wszystkie nagłówki i tytuły sekcji  
✅ Kompletne statystyki (liczby + opisy)  
✅ Wszystkie tytuły kart ofert  
✅ Wszystkie opisy ofert  
✅ Informacje kontaktowe w stopce  
✅ Nazwy profili social media  

### **Edytowalne poprzez istniejący system mediów:**
✅ Galeria zdjęć  
✅ Filmy w ramkach  
✅ Tła kart ofert  

## 🔄 **Aktualizacja z poprzedniej wersji**

Jeśli upgradeujesz z poprzedniej wersji theme'a:
1. **Pierwsze uruchomienie**: Wszystkie wartości będą wyglądać identycznie (wartości domyślne)
2. **Edycja**: Możesz stopniowo zmieniać poszczególne pola według potrzeb
3. **Bez ryzyka**: Strona nie zostanie zepsuta - wszystko działa od razu

## 📱 **Responsywność**

Wszystkie zmiany są w pełni **responsywne** i działają na wszystkich urządzeniach.

---

**Utworzono:** [Data aktualizacji]  
**Wersja theme'a:** Fotobudka WordPress Theme z pełną integracją ACF