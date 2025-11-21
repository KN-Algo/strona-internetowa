/**
 * Moduł i18n - zarządzanie wielojęzycznością strony
 */

class I18n {
  constructor() {
    this.currentLang = this.getStoredLanguage() || this.detectBrowserLanguage() || 'pl';
    this.translations = {};
    this.defaultLang = 'pl';
  }

  /**
   * Pobiera zapisany język z localStorage
   */
  getStoredLanguage() {
    return localStorage.getItem('language');
  }

  /**
   * Wykrywa język przeglądarki
   */
  detectBrowserLanguage() {
    const browserLang = navigator.language || navigator.userLanguage;
    const langCode = browserLang.split('-')[0]; // np. 'en-US' -> 'en'

    // Wspierane języki
    const supportedLangs = ['pl', 'en', 'de'];
    return supportedLangs.includes(langCode) ? langCode : null;
  }

  /**
   * Zapisuje wybrany język do localStorage
   */
  saveLanguage(lang) {
    localStorage.setItem('language', lang);
    this.currentLang = lang;
  }

  /**
   * Zwraca aktualny język
   */
  getLanguage() {
    return this.currentLang;
  }

  /**
   * Ładuje tłumaczenia dla danego języka
   */
  async loadTranslations(lang = this.currentLang) {
    try {
      const response = await fetch(`/lang/${lang}.json`);
      if (!response.ok) {
        throw new Error(`Failed to load translations for ${lang}`);
      }
      this.translations = await response.json();
      return this.translations;
    } catch (error) {
      console.error('Error loading translations:', error);
      // Fallback do języka domyślnego
      if (lang !== this.defaultLang) {
        return this.loadTranslations(this.defaultLang);
      }
      return {};
    }
  }

  /**
   * Pobiera tłumaczenie dla danego klucza (wspiera notację kropkową)
   * Przykład: t('nav.home') -> translations.nav.home
   */
  t(key) {
    const keys = key.split('.');
    let value = this.translations;

    for (const k of keys) {
      if (value && typeof value === 'object' && k in value) {
        value = value[k];
      } else {
        console.warn(`Translation key not found: ${key}`);
        return key; // Zwróć klucz jeśli nie ma tłumaczenia
      }
    }

    return value;
  }

  /**
   * Zmienia język strony
   */
  async changeLanguage(lang) {
    if (!['pl', 'en', 'de'].includes(lang)) {
      console.error(`Unsupported language: ${lang}`);
      return false;
    }

    this.saveLanguage(lang);
    await this.loadTranslations(lang);
    this.updatePageContent();
    this.updateHTMLLang();

    // Emituj event o zmianie języka
    window.dispatchEvent(new CustomEvent('languageChanged', {
      detail: { language: lang }
    }));

    return true;
  }

  /**
   * Aktualizuje atrybut lang w HTML
   */
  updateHTMLLang() {
    document.documentElement.setAttribute('lang', this.currentLang);
  }

  /**
   * Aktualizuje zawartość strony według atrybutu data-i18n
   */
  updatePageContent() {
    // Aktualizuj wszystkie elementy z data-i18n
    document.querySelectorAll('[data-i18n]').forEach(element => {
      const key = element.getAttribute('data-i18n');
      const translation = this.t(key);

      if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
        element.placeholder = translation;
      } else {
        element.innerHTML = translation;
      }
    });

    // Aktualizuj atrybuty aria-label
    document.querySelectorAll('[data-i18n-aria]').forEach(element => {
      const key = element.getAttribute('data-i18n-aria');
      element.setAttribute('aria-label', this.t(key));
    });

    // Aktualizuj atrybuty title
    document.querySelectorAll('[data-i18n-title]').forEach(element => {
      const key = element.getAttribute('data-i18n-title');
      element.setAttribute('title', this.t(key));
    });
  }

  /**
   * Inicjalizuje system i18n
   */
  async init() {
    await this.loadTranslations();
    this.updateHTMLLang();
    this.updatePageContent();

    // Nasłuchuj na kliknięcia przycisków zmiany języka
    document.querySelectorAll('[data-lang-switch]').forEach(button => {
      button.addEventListener('click', async (e) => {
        e.preventDefault();
        const lang = button.getAttribute('data-lang-switch');
        await this.changeLanguage(lang);

        // Oznacz aktywny przycisk
        document.querySelectorAll('[data-lang-switch]').forEach(btn => {
          btn.classList.remove('active');
        });
        button.classList.add('active');
      });
    });

    // Oznacz aktywny przycisk języka
    const activeButton = document.querySelector(`[data-lang-switch="${this.currentLang}"]`);
    if (activeButton) {
      activeButton.classList.add('active');
    }

    console.log(`i18n initialized with language: ${this.currentLang}`);
  }

  /**
   * Zwraca sufiks pliku danych dla aktualnego języka
   * Przykład: getDataFileSuffix() -> '_en' lub '_pl'
   */
  getDataFileSuffix() {
    return `_${this.currentLang}`;
  }

  /**
   * Buduje ścieżkę do pliku danych w odpowiednim języku
   * Przykład: getDataPath('events') -> '../data/events_en.json'
   */
  getDataPath(basename) {
    return `../data/${basename}${this.getDataFileSuffix()}.json`;
  }
}

// Utwórz globalną instancję
window.i18n = new I18n();

// Auto-inicjalizacja po załadowaniu DOM
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => window.i18n.init());
} else {
  window.i18n.init();
}
