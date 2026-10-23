export * from './auth';

export interface PageProps {
    flash?: {
        success?: string;
        error?: string;
        info?: string;
    };
    [key: string]: any;
}
