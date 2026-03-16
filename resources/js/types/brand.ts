export interface Brand {
    name: string;
    tagline: string;
    description: string;
    email: string;
    phone: string;
    address: string;
    socials: { instagram?: string; facebook?: string };
    colors: { primary: string; secondary: string; accent: string };
    fonts: { heading: string; body: string };
    logo: string;
}
